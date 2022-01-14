<?php

namespace Tokenly\Wp\Controllers\Api;

use Tokenly\Wp\Interfaces\Controllers\Api\AuthControllerInterface;
use Tokenly\Wp\Interfaces\Services\Domain\UserServiceInterface;
use Tokenly\Wp\Interfaces\Models\UserInterface;

/**
 * Defines OAuth-related endpoints
 */
class AuthController implements AuthControllerInterface {
	protected $user_service;
	protected $current_user;

	public function __construct(
		UserServiceInterface $user_service
	) {
		$this->user_service = $user_service;
		$this->current_user = $this->user_service->show_current();
	}

	/**
	 * Responds the Tokenpass connection status
	 * @return void
	*/
	public function show( \WP_REST_Request $request ) {
		if ( !$this->current_user || $this->current_user instanceof UserInterface === false ) {
			return;
		}
		$status = $this->current_user->can_connect();
		return array(
			'status' => $connected,
		);
	}
}
