<?php

namespace Tokenly\Wp\Services;

use Tokenly\Wp\Services\TokenlyService;
use Tokenly\TokenpassClient\TokenpassService;

class AuthService {
	public $tokenly_service;

	public function __construct() {
		$this->tokenly_service = new TokenlyService();
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
		if ( $is_valid === true ) {
			$client = $this->tokenly_service->make_client();
			$access_token = $client->getOAuthAccessToken( $code );
			$user = $client->getUserByToken( $access_token );
			error_log(print_r($user, true));
		} 
	}
}
