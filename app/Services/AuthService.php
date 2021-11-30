<?php

namespace Tokenly\Wp\Services;

use Tokenly\Wp\Services\Service;
use Tokenly\Wp\Interfaces\Services\AuthServiceInterface;
use Tokenly\TokenpassClient\TokenpassAPIInterface;
use Tokenly\Wp\Interfaces\Services\Domain\UserServiceInterface;
use Tokenly\Wp\Interfaces\Models\OauthUserInterface;
use Tokenly\Wp\Interfaces\Models\IntegrationSettingsInterface;
use Tokenly\Wp\Interfaces\Models\CurrentUserInterface;
use Tokenly\Wp\Interfaces\Components\ButtonLoginComponentInterface;
use Tokenly\Wp\Interfaces\Services\Domain\OauthUserServiceInterface;

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
	
	public function __construct(
		ButtonLoginComponentInterface $button_login_component,
		CurrentUserInterface $current_user,
		TokenpassAPIInterface $client,
		OauthUserServiceInterface $oauth_user_service,
		IntegrationSettingsInterface $settings,
		UserServiceInterface $user_service,
		string $oauth_callback_route
	) {
		$this->button_login_component = $button_login_component;
		$this->client = $client;
		$this->current_user = $current_user;
		$this->oauth_callback_route = $oauth_callback_route;
		$this->oauth_user_service = $oauth_user_service;
		$this->settings = $settings;
		$this->user_service = $user_service;
	}

	public function register() {
		add_action( 'login_footer', array( $this, 'embed_tokenpass_login' ) );
	}

	/**
	 * Handles response from the Tokenpass OAuth service
	 * @param string $state Unique identifier
	 * @param string $code Unique identifier
	 * @return void
	 */
	public function authorize_callback( string $state, string $code ) {
		$is_valid = $this->validate_state( $state );
		if ( $is_valid === false ) {
			return;
		}
		$oauth_user = $this->get_oauth_user_from_code( $code );
		if ( !$oauth_user ) {
			return;
		}
		if ( $this->current_user->is_guest() === false ) {
			$user = $this->current_user;
		} else {
			$can_login = $oauth_user->can_social_login();
			if ( $can_login === false ) {
				return;
			}
			$user = $this->find_existing_user( $oauth_user );
			if ( !$user ) {
				$user = $this->user_service->store( $oauth_user );
			}
		}
		if ( !$user ) {
			return;
		}
		$user->connect( $oauth_user, $oauth_user->oauth_token );
		wp_set_auth_cookie( $user->ID );
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
	public function authorize_begin() {
		$this->delete_state();
		$result = $this->get_tokenpass_login_url();
		if ( $result ) {
			$args = $result['args'] ?? null;
			if ( !$args ) {
				return;
			}
			$state;
			$state = $args['state'] ?? null;
			if ( !$state ) {
				return;
			}
			$url = $result['url'] ?? null;
			if ( !$url ) {
				return;
			}
			$this->set_state( $state );
			return array(
				'url' => $url,
			);
		}
	}

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
	 * Updates the session identifier cookie.
	 * @param string $state New session identifier
	 * @return void
	 */
	protected function set_state( string $state ) {
		setcookie( 'tokenpass-state', $state, time() + 3600, COOKIEPATH, COOKIE_DOMAIN );
	}

	/**
	 * Removes the session identifier cookie
	 * @return void
	 */
	protected function delete_state() {
		setcookie( 'tokenpass-state', '', time() - 3600, COOKIEPATH, COOKIE_DOMAIN );
	}

	/**
	 * Checks if the input session identifier matches the one currently stored.
	 * @param string $state Session identifier
	 * @return boolean
	 */
	protected function validate_state( string $state ) {
		$cookie = $_COOKIE['tokenpass-state'];
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
	 * @return array
	 */
	protected function get_tokenpass_login_url() {
		$client_id = $this->settings->client_id ?? null;
		$state = wp_generate_password( 12, false );
		$args = array(
			'client_id'     => $client_id,
			'redirect_uri'  => $this->oauth_callback_route,
			'scope'         => 'user,tca',
			'response_type' => 'code',
			'state'         => $state,
		);
		$url = add_query_arg( $args, 'https://tokenpass.tokenly.com/oauth/authorize' );
		return array(
			'args' => $args,
			'url'  => $url,
		);
	}
}
