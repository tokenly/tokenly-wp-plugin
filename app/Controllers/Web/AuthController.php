<?php

namespace Tokenly\Wp\Controllers\Web;

use Tokenly\Wp\Interfaces\Controllers\Web\AuthControllerInterface;
use Tokenly\Wp\Interfaces\Services\AuthServiceInterface;
use Tokenly\Wp\Interfaces\Services\Domain\UserServiceInterface;
use Tokenly\Wp\Interfaces\Models\UserInterface;

/**
 * Serves the auth web routes
 */
class AuthController implements AuthControllerInterface {
	protected $auth_service;
	protected $current_user;
	protected $user_service;
	protected $namespace;

	public function __construct(
		AuthServiceInterface $auth_service,
		UserServiceInterface $user_service,
		string $namespace
	) {
		$this->auth_service = $auth_service;
		$this->user_service = $user_service;
		$this->current_user = $user_service->show_current();
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
		if ( !$this->current_user || $this->current_user instanceof UserInterface === false ) {
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
