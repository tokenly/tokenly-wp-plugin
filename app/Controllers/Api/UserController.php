<?php

namespace Tokenly\Wp\Controllers\Api;

use Tokenly\Wp\Interfaces\Controllers\Api\UserControllerInterface;
use Tokenly\Wp\Interfaces\Repositories\UserRepositoryInterface;

class UserController implements UserControllerInterface {
	public function __construct(
		UserRepositoryInterface $user_repository
	) {
		$this->user_repository = $user_repository;
	}
	
	public function index( $request ) {
		$params = $request->get_params();
		$users = $this->user_repository->index( $params );
		return $users;
	}

	public function show( $request ) {
		$id = (string) $request['id'];
		if ( !$id ) {
			return;
		}
		$user = $this->user_repository->show( $id );
		return $user;
	}
}
