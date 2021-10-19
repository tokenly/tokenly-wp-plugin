<?php

namespace Tokenly\Wp\Services;

use Tokenly\Wp\Services\TokenpassService;
use Tokenly\Wp\Services\UserService;
use Tokenly\Wp\Components\ButtonLoginComponent;

class AuthService {
	public $tokenly_service;
	public $user_service;

	public function __construct() {
		$this->tokenly_service = new TokenpassService();
		$this->user_service = new UserService();
	}

	/**
	 * Updates the session identifier cookie.
	 * @param string $state New session identifier
	 * @return void
	 */
	public function set_state( $state ) {
		setcookie( 'tokenpass-state', $state, time() + 3600, COOKIEPATH, COOKIE_DOMAIN );
	}

	/**
	 * Removes the session identifier cookie
	 * @return void
	 */
	public function delete_state() {
		setcookie( 'tokenpass-state', '', time() - 3600, COOKIEPATH, COOKIE_DOMAIN );
	}

	/**
	 * Checks if the input session identifier matches the one currently stored.
	 * @param string $state Session identifier
	 * @return boolean
	 */
	public function validate_state( $state ) {
		$cookie = $_COOKIE['tokenpass-state'];
		$valid = false;
		if ( $cookie ) {
			$valid = $cookie === $state;
		}
		return $valid;
	}

	public function can_social_login( $tokenpass_user ) {
		$email = $tokenpass_user['email'] ?? null;
		$email_is_confirmed = $tokenpass_user['email_is_confirmed'] ?? null;
		if ( !$email || $email_is_confirmed === false ) {
			return false;	
		}
		return true;
	}

	public function find_existing_user( $tokenpass_user ) {
		$email = $tokenpass_user['email'] ?? null;
		if ( !$email ) {
			return false;
		}
		$user = get_user_by( 'email', $email );
		return $user;
	}

	public function create_user_from_tokenpass_user( $tokenpass_user ) {
		$username = $tokenpass_user['username'] ?? null;
		$password = wp_generate_password( 12, false );
		$email = $tokenpass_user['email'] ?? null;
		$user_id = wp_create_user( $username, $password, $email );
		if ( is_numeric( $user_id ) === false ) {
			return false;
		}
		$user = get_user_by( 'id', $user_id );
		return $user;
	}

	public function authorize_callback( $state, $code ) {
		$is_valid = $this->validate_state( $state );
		if ( $is_valid === false ) {
			return;
		}
		$client = $this->tokenly_service->make_client();
		$access_token = $client->getOAuthAccessToken( $code );
		if ( !$access_token ) {
			return;
		}
		$tokenpass_user = $client->getUserByToken( $access_token );
		if ( $tokenpass_user ) {
			$can_login = $this->can_social_login( $tokenpass_user );
			if ( $can_login === false ) {
				return;
			}
			$user = $this->find_existing_user( $tokenpass_user );
			if ( !$user ) {
				$user = $this->create_user_from_tokenpass_user( $tokenpass_user );
			}
			if ( !$user ) {
				return;
			}
			update_user_meta( $user->ID, 'tokenly_uuid', $tokenpass_user['id'] ?? null );
			update_user_meta( $user->ID, 'tokenly_oauth_token', $access_token );
			wp_set_auth_cookie( $user->ID );
		}
	}

	public function embed_tokenpass_login() {
		error_log(123);
		$login_button = new ButtonLoginComponent();
		echo $login_button->render();
	}
}
