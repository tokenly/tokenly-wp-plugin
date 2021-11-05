<?php

namespace Tokenly\Wp\Controllers\Api;

use Tokenly\Wp\Interfaces\Controllers\Api\AuthControllerInterface;
use Tokenly\Wp\Interfaces\Services\AuthServiceInterface;

/**
 * Defines OAuth-related endpoints
 */
class AuthController implements AuthControllerInterface {
	public $auth_service;

	public function __construct(
		AuthServiceInterface $auth_service
	) {
		$this->auth_service = $auth_service;
	}

	/** Responds with Tokenpass connection status */
	public function status() {
		$id = get_current_user_id();
		$connected = $this->auth_service->is_connected( $id );
		return array(
			'status' => $connected
		);
	}

	/**
	 * Begins OAuth process
	 */
	public function authorize( $request ) {
		return $this->auth_service->authorize_begin();
	}

	/**
	 * Handles OAuth callback
	 */
	public function authorize_callback() {
		$code = $_GET['code'] ?? null;
		$state = $_GET['state'] ?? null;
		if ( !$code || !$state ) {
			return;
		}
		$result = $this->auth_service->authorize_callback( $state, $code );
		wp_redirect( '/wp-admin/admin.php?page=tokenpass-connection' );
		exit();
	}
	
	public function disconnect() {
		$result = $this->auth_service->disconnect();
		return array(
			'status' => 'Successfully disconnected!'
		);
	}
}
