<?php

namespace Tokenly\Wp\Services;

use Tokenly\Wp\Services\TokenlyService;
use Tokenly\Wp\Services\UserService;
use Tokenly\TokenpassClient\TokenpassService;

class AuthService {
	public $tokenly_service;
	public $user_service;

	public function __construct() {
		$this->tokenly_service = new TokenlyService();
		$this->user_service = new UserService();
	}

	public function set_state( $state ) {
		setcookie( 'tokenpass-state', $state, time() + 3600, COOKIEPATH, COOKIE_DOMAIN );
	}

	public function delete_state() {
		setcookie( 'tokenpass-state', '', time() - 3600, COOKIEPATH, COOKIE_DOMAIN );
	}

	public function validate_state( $state ) {
		$cookie = $_COOKIE['tokenpass-state'];
		if ( $cookie ) {
			return $cookie === $state;
		}
	}

	public function authorize_callback( $state, $code ) {
		$is_valid = $this->validate_state( $state );
		error_log($is_valid);
		if ( $is_valid === false ) {
			return;
		}
		$client = $this->tokenly_service->make_client();
		$access_token = $client->getOAuthAccessToken( $code );
		error_log($access_token);
		$tokenpass_user = $client->getUserByToken( $access_token );
		if ( $tokenpass_user ) {
			error_log(print_r($tokenpass_user, true));
			$username = $tokenpass_user['username'] ?? null;
			$email = $tokenpass_user['email'] ?? null;
			$email_is_confirmed = $tokenpass_user['email_is_confirmed'] ?? null;
			$local_user;
			if ( !$email || $email_is_confirmed === false ) {
				return;	
			}
			$local_user = get_user_by( 'email', $email );
			error_log(print_r($local_user, true));
			if ( !$local_user ) {
				$password = wp_generate_password();
				$local_user = wp_create_user( $username, $password, $email );
				error_log(print_r($local_user, true));
			}
			$uuid = $tokenpass_user['id'] ?? null;
			if ( !$uuid ) {
				return;
			}
			$user_id = $local_user->ID;
			update_user_meta( $user_id, 'tokenly_uuid', $uuid );
			wp_set_auth_cookie( $user_id );
		}
		if ( is_user_logged_in() === true ) {
			
		} else {
			
		}
	}
}
