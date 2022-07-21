<?php

namespace Tokenly\Wp\Controllers\Api;

use Tokenly\Wp\Interfaces\Controllers\Api\AuthControllerInterface;

use Tokenly\Wp\Interfaces\Repositories\UserRepositoryInterface;
use Tokenly\Wp\Interfaces\Models\UserInterface;

/**
 * Defines OAuth-related endpoints
 */
class AuthController implements AuthControllerInterface {
	protected UserRepositoryInterface $user_repository;
	protected ?UserInterface $current_user;

	public function __construct(
		UserRepositoryInterface $user_repository
	) {
		$this->user_repository = $user_repository;
		$this->current_user = $this->user_repository->show_current();
	}

	/**
	 * Gets the OAuth connection status
	 * @param \WP_REST_Request $request Request data
	 * @return \WP_REST_Response
	*/
	public function show( \WP_REST_Request $request ): \WP_REST_Response {
		if ( !isset( $this->current_user ) || $this->current_user instanceof UserInterface === false ) {
			$status = false;
		} else {
			$status = $this->current_user->can_connect;
		}
		return new \WP_REST_Response( array(
			'status' => $status,
		) );
	}
}
