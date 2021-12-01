<?php

namespace Tokenly\Wp\Services;

use Tokenly\Wp\Services\Service;
use Tokenly\Wp\Interfaces\Services\AuthServiceInterface;
use Tokenly\Wp\Interfaces\Services\Domain\UserServiceInterface;
use Tokenly\Wp\Interfaces\Services\Domain\OauthUserServiceInterface;
use Tokenly\Wp\Interfaces\Models\CurrentUserInterface;
use Tokenly\Wp\Interfaces\Models\OauthUserInterface;
use Tokenly\Wp\Interfaces\Models\IntegrationSettingsInterface;
use Tokenly\Wp\Interfaces\Components\ButtonLoginComponentInterface;
use Tokenly\TokenpassClient\TokenpassAPIInterface;

/**
 * Handles the Tokenpass authentication flow (OAuth)
 */
class AuthService extends Service implements AuthServiceInterface {
	protected $button_login_component;
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
	
	public function __construct(
		ButtonLoginComponentInterface $button_login_component,
		CurrentUserInterface $current_user,
		TokenpassAPIInterface $client,
		OauthUserServiceInterface $oauth_user_service,
		IntegrationSettingsInterface $settings,
		UserServiceInterface $user_service,
		string $oauth_callback_route,
		string $api_host,
		string $namespace
	) {
		$this->api_host = $api_host;
		$this->namespace = $namespace;
		$this->button_login_component = $button_login_component;
		$this->client = $client;
		$this->current_user = $current_user;
		$this->oauth_callback_route = $oauth_callback_route;
		$this->oauth_user_service = $oauth_user_service;
		$this->settings = $settings;
		$this->user_service = $user_service;
		$this->state_cookie_name = "{$this->namespace}_oauth_state";
		$this->success_url_cookie_name = "{$this->namespace}_oauth_success_url";
	}

	/**
	 * Registers the service
	 * @return void
	 */
	public function register() {
		add_action( 'login_footer', array( $this, 'embed_tokenpass_login' ) );
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
		echo $this->button_login_component->render();
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
		if ( $this->current_user->is_guest() === false ) {
			$user = $this->current_user;
		} else {
			$can_login = $oauth_user->can_social_login();
			if ( $can_login === false ) {
				return false;
			}
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
	 * @return mixed
	 */
	protected function find_existing_user( OauthUserInterface $oauth_user ) {
		$uuid = $oauth_user->id ?? null;
		$email = $oauth_user->email ?? null;
		$user;
		if ( $uuid ) {
			$user = $this->user_service->show( array(
				'uuid' => $uuid,
			) );
			if ( $user ) {
				return $user;
			}
		}
		if ( $email ) {
			$user = $this->user_service->show( array(
				'email' => $email,
			) );
			if ( $user ) {
				return $user;
			}
		}
	}

	/**
	 * Constructs Tokenpass OAuth login link
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
