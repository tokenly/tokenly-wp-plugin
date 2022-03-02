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
	 * @return array
	*/
	public function show( \WP_REST_Request $request ): array {
		if ( !isset( $this->current_user ) || $this->current_user instanceof UserInterface === false ) {
			return array(
				'status' => false,
			);
		}
		$status = $this->current_user->get_can_connect();
		return array(
			'status' => $connected,
		);
	}
}
