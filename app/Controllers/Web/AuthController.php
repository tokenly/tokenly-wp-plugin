<?php

namespace Tokenly\Wp\Controllers\Web;

use Tokenly\Wp\Interfaces\Controllers\Web\AuthControllerInterface;
use Tokenly\Wp\Interfaces\Services\AuthServiceInterface;
use Tokenly\Wp\Interfaces\Models\CurrentUserInterface;

/**
 * Serves the auth web routes
 */
class AuthController implements AuthControllerInterface {
	protected $auth_service;
	protected $current_user;
	protected $namespace;

	public function __construct(
		AuthServiceInterface $auth_service,
		CurrentUserInterface $current_user,
		string $namespace
	) {
		$this->auth_service = $auth_service;
		$this->current_user = $current_user;
		$this->namespace = $namespace;
	}
	
	/**
	 * Initiates the OAuth process
	 * @return void
	 */
	public function store() {
		$success_url = get_query_var( "{$this->namespace}_success_url" );
		$this->auth_service->authorize_begin( $success_url );
	}

	/**
	 * Disconnects the current user
	 * @return array
	 */
	public function destroy() {
		if ( $this->current_user->is_guest() === true ) {
			return;
		}
		$this->current_user->disconnect();
		wp_redirect( "/wp-admin/admin.php?page={$this->namespace}-connection" );
		exit;
	}

	/**
	 * Handles OAuth callback
	 * @return void
	 */
	public function callback() {
		if ( !isset( $_GET['code'] ) || !isset( $_GET['state'] ) ) {
			wp_redirect( home_url() );
			exit;
		}
		$this->auth_service->authorize_callback( $_GET['state'], $_GET['code'] );
	}
}