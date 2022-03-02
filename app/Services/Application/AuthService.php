<?php

namespace Tokenly\Wp\Services\Application;

use Tokenly\Wp\Services\Service;
use Tokenly\Wp\Interfaces\Services\Application\AuthServiceInterface;

use Tokenly\Wp\Interfaces\Repositories\UserRepositoryInterface;
use Tokenly\Wp\Interfaces\Repositories\OauthUserRepositoryInterface;
use Tokenly\Wp\Interfaces\Repositories\General\UserMetaRepositoryInterface;
use Tokenly\Wp\Interfaces\Repositories\Settings\IntegrationSettingsRepositoryInterface;
use Tokenly\Wp\Interfaces\Repositories\Settings\OauthSettingsRepositoryInterface;
use Tokenly\Wp\Interfaces\Models\OauthUserInterface;
use Tokenly\Wp\Interfaces\Models\UserInterface;
use Tokenly\Wp\Interfaces\Models\Settings\IntegrationSettingsInterface;
use Tokenly\Wp\Interfaces\Models\Settings\OauthSettingsInterface;
use Tokenly\Wp\Interfaces\Presentation\Components\LoginButtonComponentModelInterface;
use Tokenly\TokenpassClient\TokenpassAPIInterface;
use Twig\Environment;

/**
 * Handles the Tokenpass authentication flow (OAuth)
 */
class AuthService extends Service implements AuthServiceInterface {
	protected TokenpassAPIInterface $client;
	protected ?UserInterface $current_user;
	protected string $oauth_callback_route;
	protected OauthUserRepositoryInterface $oauth_user_repository;
	protected UserRepositoryInterface $user_repository;
	protected string $api_host;
	protected string $namespace;
	protected string $state_cookie_name;
	protected string $success_url_cookie_name;
	protected IntegrationSettingsInterface $integration_settings;
	protected OauthSettingsInterface $oauth_settings;
	protected UserMetaRepositoryInterface $user_meta_repository;
	protected IntegrationSettingsRepositoryInterface $integration_settings_repository;
	protected OauthSettingsRepositoryInterface $oauth_settings_repository;
	
	public function __construct(
		TokenpassAPIInterface $client,
		OauthUserRepositoryInterface $oauth_user_repository,
		UserRepositoryInterface $user_repository,
		IntegrationSettingsRepositoryInterface $integration_settings_repository,
		OauthSettingsRepositoryInterface $oauth_settings_repository,
		UserMetaRepositoryInterface $user_meta_repository,
		string $oauth_callback_route,
		string $api_host,
		string $namespace
	) {
		$this->api_host = $api_host;
		$this->namespace = $namespace;
		$this->client = $client;
		$this->user_repository = $user_repository;
		$this->current_user = $this->user_repository->show_current();
		$this->oauth_callback_route = $oauth_callback_route;
		$this->oauth_user_repository = $oauth_user_repository;
		$this->user_meta_repository = $user_meta_repository;
		$this->integration_settings_repository = $integration_settings_repository;
		$this->oauth_settings_repository = $oauth_settings_repository;
		$this->integration_settings = $this->integration_settings_repository->show();
		$this->oauth_settings = $this->oauth_settings_repository->show();
		$this->state_cookie_name = "{$this->namespace}_oauth_state";
		$this->success_url_cookie_name = "{$this->namespace}_oauth_success_url";
	}

	/**
	 * @inheritDoc
	 */
	public function register(): void {
		if ( $this->oauth_settings->get_use_single_sign_on() == true ) {
			add_action( 'login_footer', array( $this, 'embed_tokenpass_login' ) );
		}
	}

	/**
	 * Handles response from the Tokenpass OAuth service
	 * @param string $state Unique identifier
	 * @param string $code Unique identifier
	 * @return bool
	 */
	public function authorize_callback( string $state, string $code ): bool {
		$success = $this->authorize( $state, $code );
		$on_failure_url = home_url();
		$on_success_url = $_COOKIE[ $this->success_url_cookie_name ] ?? $on_failure_url;
		$redirect_url = $success ? $on_success_url : $on_failure_url;
		$this->reset_state();
		$this->reset_success_url();
		wp_redirect( $redirect_url );
		exit;
	}

	/**
	 * Embeds Tokenpass login button on the WordPress login page
	 * @return void
	 */
	public function embed_tokenpass_login(): void {
		echo do_shortcode( "[{$this->namespace}_login]" );
	}

	/**
	 * Validates the Tokenpass login link and returns it to the user
	 * @return void
	 */
	public function authorize_begin( ?string $success_url ): void {
		$state = wp_generate_password( 12, false );
		$this->set_state( $state );
		if ( !$success_url ) {
			$success_url = $this->oauth_settings->get_success_url();
		}
		$this->set_success_url( $success_url );
		$url = $this->get_tokenpass_login_url( $state );
		wp_redirect( $url );
		exit;
	}

	/**
	 * Connects the User to Tokenpass
	 * @param UserInterface $user Target User
	 * @param OauthUserInterface $oauth_user OAuth user to associate the current user with
	 * @param string $oauth_token OAuth token of the OAuth user
	 * @return void
	 */
	public function connect_user( UserInterface $user, OauthUserInterface $oauth_user, string $oauth_token ): self {
		$this->user_repository->update( $user, array(
			'uuid'        => $oauth_user->get_id(),
			'oauth_token' => $oauth_token,
			'can_connect' => true,
		) );
		$user->add_cap( 'use_tokenpass' );
		return $this;
	}

	/**
	 * Disconnects the User from Tokenpass
	 * @param UserInterface $user Target User
	 * @return void
	 */
	public function disconnect_user( UserInterface $user ): void {
		$this->user_meta_repository->destroy( $user->ID, ...array( 'uuid', 'oauth_token', 'can_connect' ) );
		$user->remove_cap( 'use_tokenpass');
	}

	/**
	 * Main auth pipeline
	 * @param string $state State
	 * @param string $code Code
	 * @return bool
	 */
	protected function authorize( string $state, string $code ): bool {
		$is_valid = $this->validate_state( $state );
		if ( $is_valid === false ) {
			return false;
		}
		$oauth_user = $this->get_oauth_user_from_code( $code );
		if ( !$oauth_user ) {
			return false;
		}
		$can_login = $oauth_user->can_social_login( $this->oauth_settings );
		if ( $can_login === false ) {
			return false;
		}
		if ( $this->current_user && $this->current_user instanceof UserInterface ) {
			$user = $this->current_user;
		} else {
			$user = $this->find_existing_user( $oauth_user );
			if ( !$user ) {
				$user = $this->user_repository->store( $oauth_user );
			}
		}
		if ( !$user ) {
			return false;
		}
		$this->connect_user( $user, $oauth_user, $oauth_user->get_oauth_token() );
		wp_set_auth_cookie( $user->ID );
		return true;
	}

	/**
	 * Gets the OAuth user from the code
	 * @param string $code The code
	 * @return OauthUserInterface|null
	 */
	protected function get_oauth_user_from_code( string $code ): ?OauthUserInterface {
		$oauth_token = $this->client->getOAuthAccessToken( $code );
		if ( !$oauth_token ) {
			return null;
		}
		$oauth_user = $this->oauth_user_repository->show( array(
			'oauth_token' => $oauth_token,
		) );
		return $oauth_user;
	}

	/**
	 * Sets the url where the user will be redirected
	 * after successfull authentication
	 * @param string $url New success url
	 * @return bool
	 */
	protected function set_success_url( string $url ): bool {
		return setcookie( $this->success_url_cookie_name, $url, time() + 3600, COOKIEPATH, COOKIE_DOMAIN );
	}

	/**
	 * Resets the success url
	 * @return bool
	 */
	protected function reset_success_url(): bool {
		return setcookie( $this->success_url_cookie_name, '', time() - 3600, COOKIEPATH, COOKIE_DOMAIN );
	}

	/**
	 * Updates the session identifier cookie.
	 * @param string $state New session identifier
	 * @return bool
	 */
	protected function set_state( string $state ): bool {
		return setcookie( $this->state_cookie_name, $state, time() + 3600, COOKIEPATH, COOKIE_DOMAIN );
	}

	/**
	 * Resets the session state
	 * @return bool
	 */
	protected function reset_state(): bool {
		return setcookie( $this->state_cookie_name, '', time() - 3600, COOKIEPATH, COOKIE_DOMAIN );
	}

	/**
	 * Checks if the input session identifier matches the one currently stored.
	 * @param string $state Session identifier
	 * @return bool
	 */
	protected function validate_state( string $state ): bool {
		$cookie = $_COOKIE[ $this->state_cookie_name ];
		$valid = false;
		if ( $cookie ) {
			$valid = $cookie === $state;
		}
		return $valid;
	}

	/**
	 * Searches for WordPress user using Tokenpass user data
	 * @param OauthUserInterface $oauth_user Tokenpass user data
	 * @return UserInterface|null
	 */
	protected function find_existing_user( OauthUserInterface $oauth_user ): ?UserInterface {
		$user;
		if ( $oauth_user->get_id() ) {
			$user = $this->user_repository->show( array(
				'uuid' => $oauth_user->get_id(),
			) );
			if ( $user ) {
				return $user;
			}
		}
		if ( $oauth_user->get_email() ) {
			$user = $this->user_repository->show( array(
				'email' => $oauth_user->get_email(),
			) );
			if ( $user ) {
				return $user;
			}
		}
	}

	/**
	 * Constructs Tokenpass OAuth login link
	 * @param string $state OAuth state
	 * @return string
	 */
	protected function get_tokenpass_login_url( string $state ) {
		if ( !$this->integration_settings->get_client_id() ) {
			return;
		}
		$args = array(
			'client_id'     => $this->integration_settings->get_client_id(),
			'redirect_uri'  => $this->oauth_callback_route,
			'scope'         => 'user,tca,manage-address',
			'response_type' => 'code',
			'state'         => $state,
		);
		$url = add_query_arg( $args, "{$this->api_host}/oauth/authorize" );
		return $url;
	}
}
