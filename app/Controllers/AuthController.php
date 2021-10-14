<?php

namespace Tokenly\Wp\Controllers;

use Tokenly\Wp\Services\TokenlyService;
use Tokenly\Wp\Services\AuthService;

class AuthController {
	public $auth_service;
	public $tokenly_service;

	public function __construct() {
		$this->auth_service = new AuthService();
		$this->tokenly_service = new TokenlyService();
	}

	public function authorize( $request ) {
		$result = $this->tokenly_service->get_tokenpass_login_url();
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
			$this->auth_service->set_state( $state );
			wp_redirect( $url );
			exit;
		}
	}

	public function authorize_callback( $request ) {
		$code = $request['code'] ?? null;
		$state = $request['state'] ?? null;
		if ( !$code || !$state ) {
			return;
		}
		$result = $this->auth_service->authorize_callback( $state, $code );
	}
}
