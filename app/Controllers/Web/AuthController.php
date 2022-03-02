<?php

namespace Tokenly\Wp\Controllers\Web;

use Tokenly\Wp\Interfaces\Controllers\Web\AuthControllerInterface;
use Tokenly\Wp\Interfaces\Services\Application\AuthServiceInterface;
use Tokenly\Wp\Interfaces\Repositories\UserRepositoryInterface;
use Tokenly\Wp\Interfaces\Repositories\Settings\OauthSettingsRepositoryInterface;
use Tokenly\Wp\Interfaces\Models\UserInterface;
use Tokenly\Wp\Interfaces\Models\Settings\OauthSettingsInterface;

/**
 * Serves the auth web routes
 */
class AuthController implements AuthControllerInterface {
	protected AuthServiceInterface $auth_service;
	protected ?UserInterface $current_user;
	protected UserRepositoryInterface $user_repository;
	protected string $namespace;
	protected OauthSettingsRepositoryInterface $oauth_settings_repository;
	protected OauthSettingsInterface $oauth_settings;

	public function __construct(
		AuthServiceInterface $auth_service,
		UserRepositoryInterface $user_repository,
		OauthSettingsRepositoryInterface $oauth_settings_repository,
		string $namespace
	) {
		$this->auth_service = $auth_service;
		$this->user_repository = $user_repository;
		$this->current_user = $this->user_repository->show_current();
		$this->oauth_settings_repository = $oauth_settings_repository;
		$this->oauth_settings = $this->oauth_settings_repository->show();
		$this->namespace = $namespace;
	}

	public function show() {
		//
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
		$success_url = get_query_var( "{$this->namespace}_success_url" );
		if ( !$success_url ) {
			$success_url = $this->oauth_settings->get_success_url();
		}
		if ( !$this->current_user || $this->current_user instanceof UserInterface === false ) {
			return;
		}
		$this->auth_service->disconnect_user( $this->current_user );
		wp_redirect( $success_url );
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
