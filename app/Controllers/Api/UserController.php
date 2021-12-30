<?php

namespace Tokenly\Wp\Controllers\Api;

use Tokenly\Wp\Controllers\Controller;
use Tokenly\Wp\Interfaces\Controllers\Api\UserControllerInterface;

use Tokenly\Wp\Interfaces\Services\Domain\UserServiceInterface;
use Tokenly\Wp\Interfaces\Models\UserInterface;
use Tokenly\Wp\Interfaces\Collections\UserCollectionInterface;

class UserController extends Controller implements UserControllerInterface {
	public function __construct(
		UserServiceInterface $user_service
	) {
		$this->user_service = $user_service;
	}
	
	/**
	 * Gets a collection of users
	 * @param UserCollectionInterface $users Bound users
	 * @param \WP_REST_Request $request Request
	 * @return array
	 */
	public function index( UserCollectionInterface $users, \WP_REST_Request $request ) {
		$users = $users->to_array();
		return $users;
	}

	/**
	 * Gets a single user
	 * @param UserInterface $user Bound user
	 * @param \WP_REST_Request $request Request
	 * @return array
	 */
	public function show( UserInterface $user, \WP_REST_Request $request ) {
		$user = $user->to_array();
		return $user;
	}

	/**
	 * Gets model binding parameters
	 * @return array
	 */
	protected function get_bind_params() {
		return array(
			'service'                   => $this->user_service,
			'single_methods'            => array( 'show' ),
			'single_service_method'     => 'show',
			'collection_methods'        => array( 'index' ),
			'collection_service_method' => 'index',
		);
	}
}
