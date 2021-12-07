<?php

namespace Tokenly\Wp\Controllers\Api;

use Tokenly\Wp\Interfaces\Controllers\Api\UserControllerInterface;
use Tokenly\Wp\Interfaces\Services\Domain\UserServiceInterface;
use Tokenly\Wp\Interfaces\Models\UserInterface;
use Tokenly\Wp\Interfaces\Collections\UserCollectionInterface;

class UserController implements UserControllerInterface {
	public function __construct(
		UserServiceInterface $user_service
	) {
		$this->user_service = $user_service;
	}
	
	/**
	 * Responds with a collection of users
	 * @param \WP_REST_Request $request Request
	 * @return array
	 */
	public function index( \WP_REST_Request $request ) {
		$params = $request->get_params();
		$users = $this->user_service->index( $params );
		if ( isset( $params['suggestions'] ) ) {
			return $users->to_suggestions();
		}
		$users = $users->to_array();
		return $users;
	}

	/**
	 * Responds with a single user
	 * @param \WP_REST_Request $request Request
	 * @return UserInterface
	 */
	public function show( \WP_REST_Request $request ) {
		$id = (string) $request['id'];
		if ( !$id ) {
			return;
		}
		$user = $this->user_service->show( $id );
		$user = $user->to_array();
		return $user;
	}
}
