<?php

namespace Tokenly\Wp\Controllers\Api;

use Tokenly\Wp\Services\AuthService;

class AuthController {
	public $auth_service;

	public function __construct(
		AuthService $auth_service
	) {
		$this->auth_service = $auth_service;
	}

	public function status() {
		$id = get_current_user_id();
		$connected = $this->auth_service->is_connected( $id );
		return array(
			'status' => $connected
		);
	}

	public function authorize( $request ) {
		$this->auth_service->authorize_begin();
	}

	public function authorize_callback( $request ) {
		$code = $request['code'] ?? null;
		$state = $request['state'] ?? null;
		if ( !$code || !$state ) {
			return;
		}
		$result = $this->auth_service->authorize_callback( $state, $code );
		wp_redirect( get_site_url() );
		exit();
	}
}
