<?php

namespace Tokenly\Wp\Services;

use Tokenly\Wp\Services\Service;
use Tokenly\Wp\Interfaces\Services\AuthServiceInterface;
use Tokenly\Wp\Interfaces\Services\Domain\UserServiceInterface;
use Tokenly\Wp\Interfaces\Services\Domain\OauthUserServiceInterface;
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
	protected $login_button_component_model;
	protected $client;
	protected $current_user;
	protected $oauth_callback_route;
	protected $oauth_user_service;
	protected $settings;
	protected $user_service;
	protected $api_host;
	protected $namespace;
	protected $state_cookie_name;
	protected $success_url_cookie_name;
	protected $oauth_settings;
	protected $twig;
	
	public function __construct(
		LoginButtonComponentModelInterface $login_button_component_model,
		TokenpassAPIInterface $client,
		OauthUserServiceInterface $oauth_user_service,
		IntegrationSettingsInterface $settings,
		UserServiceInterface $user_service,
		OauthSettingsInterface $oauth_settings,
		Environment $twig,
		string $oauth_callback_route,
		string $api_host,
		string $namespace
	) {
		$this->api_host = $api_host;
		$this->namespace = $namespace;
		$this->login_button_component_model = $login_button_component_model;
		$this->client = $client;
		$this->user_service = $user_service;
		$this->current_user = $this->user_service->show_current();
		$this->oauth_callback_route = $oauth_callback_route;
		$this->oauth_user_service = $oauth_user_service;
		$this->settings = $settings;

		$this->oauth_settings = $oauth_settings;
		$this->twig = $twig;
		$this->state_cookie_name = "{$this->namespace}_oauth_state";
		$this->success_url_cookie_name = "{$this->namespace}_oauth_success_url";
	}

	/**
	 * Registers the service
	 * @return void
	 */
	public function register() {
		if ( $this->oauth_settings->use_single_sign_on == true ) {
			add_action( 'login_footer', array( $this, 'embed_tokenpass_login' ) );
		}
	}

	/**
	 * Handles response from the Tokenpass OAuth service
	 * @param string $state Unique identifier
	 * @param string $code Unique identifier
	 * @return bool
	 */
	public function authorize_callback( string $state, string $code ) {
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
	public function embed_tokenpass_login() {
		echo do_shortcode( "[{$this->namespace}_login]" );
	}

	/**
	 * Validates the Tokenpass login link and returns it to the user
	 * @return array
	 */
	public function authorize_begin( string $success_url ) {
		$state = wp_generate_password( 12, false );
		$this->set_state( $state );
		$this->set_success_url( $success_url );
		$url = $this->get_tokenpass_login_url( $state );
		wp_redirect( $url );
		exit;
	}

	/**
	 * Main auth pipeline
	 * @param string $state State
	 * @param string $code Code
	 * @return bool
	 */
	protected function authorize( string $state, string $code ) {
		$is_valid = $this->validate_state( $state );
		if ( $is_valid === false ) {
			return false;
		}
		$oauth_user = $this->get_oauth_user_from_code( $code );
		if ( !$oauth_user ) {
			return false;
		}
		$can_login = $oauth_user->can_social_login();
		if ( $can_login === false ) {
			return false;
		}
		if ( $this->current_user && $this->current_user instanceof UserInterface ) {
			$user = $this->current_user;
		} else {
			$user = $this->find_existing_user( $oauth_user );
			if ( !$user ) {
				$user = $this->user_service->store( $oauth_user );
			}
		}
		if ( !$user ) {
			return false;
		}
		$user->connect( $oauth_user, $oauth_user->oauth_token );
		wp_set_auth_cookie( $user->ID );
		return true;
	}

	/**
	 * Gets the OAuth user from the code
	 * @param string $code The code
	 * @return OauthUserInterface
	 */
	protected function get_oauth_user_from_code( string $code ) {
		$oauth_token = $this->client->getOAuthAccessToken( $code );
		if ( !$oauth_token ) {
			return;
		}
		$oauth_user = $this->oauth_user_service->show( array(
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
	protected function set_success_url( string $url ) {
		return setcookie( $this->success_url_cookie_name, $url, time() + 3600, COOKIEPATH, COOKIE_DOMAIN );
	}

	/**
	 * Resets the success url
	 * @return bool
	 */
	protected function reset_success_url() {
		return setcookie( $this->success_url_cookie_name, '', time() - 3600, COOKIEPATH, COOKIE_DOMAIN );
	}

	/**
	 * Updates the session identifier cookie.
	 * @param string $state New session identifier
	 * @return bool
	 */
	protected function set_state( string $state ) {
		return setcookie( $this->state_cookie_name, $state, time() + 3600, COOKIEPATH, COOKIE_DOMAIN );
	}

	/**
	 * Resets the session state
	 * @return bool
	 */
	protected function reset_state() {
		return setcookie( $this->state_cookie_name, '', time() - 3600, COOKIEPATH, COOKIE_DOMAIN );
	}

	/**
	 * Checks if the input session identifier matches the one currently stored.
	 * @param string $state Session identifier
	 * @return bool
	 */
	protected function validate_state( string $state ) {
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
	 * @return UserInterface
	 */
	protected function find_existing_user( OauthUserInterface $oauth_user ) {
		$user;
		if ( isset( $oauth_user->id ) ) {
			$user = $this->user_service->show( array(
				'uuid' => $oauth_user->id,
			) );
			if ( $user ) {
				return $user;
			}
		}
		if ( isset( $oauth_user->email ) ) {
			$user = $this->user_service->show( array(
				'email' => $oauth_user->email,
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
		if ( !isset( $this->settings->client_id ) ) {
			return;
		}
		$args = array(
			'client_id'     => $this->settings->client_id,
			'redirect_uri'  => $this->oauth_callback_route,
			'scope'         => 'user,tca',
			'response_type' => 'code',
			'state'         => $state,
		);
		$url = add_query_arg( $args, "{$this->api_host}/oauth/authorize" );
		return $url;
	}
}
