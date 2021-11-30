<?php

namespace Tokenly\Wp\Controllers\Api;

use Tokenly\Wp\Interfaces\Controllers\Api\AuthControllerInterface;
use Tokenly\Wp\Interfaces\Services\AuthServiceInterface;
use Tokenly\Wp\Interfaces\Models\CurrentUserInterface;

/**
 * Defines OAuth-related endpoints
 */
class AuthController implements AuthControllerInterface {
	protected $auth_service;
	protected $current_user;

	public function __construct(
		AuthServiceInterface $auth_service,
		CurrentUserInterface $current_user
	) {
		$this->auth_service = $auth_service;
		$this->current_user = $current_user;
	}

	/** Responds with Tokenpass connection status */
	public function status() {
		if ( $this->current_user->is_guest() === true ) {
			return;
		}
		$status = $this->current_user->can_connect();
		return array(
			'status' => $connected,
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
		wp_redirect( '/wp-admin/admin.php?page=tokenly-connection' );
		exit();
	}
	
	public function disconnect() {
		if ( $this->current_user->is_guest() === true ) {
			return;
		}
		$this->current_user->disconnect();
		return array(
			'status' => 'Successfully disconnected!'
		);
	}
}
