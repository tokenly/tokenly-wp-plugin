<?php

namespace Tokenly\Wp\Controllers\Api;

use Tokenly\Wp\Interfaces\Controllers\Api\UserControllerInterface;
use Tokenly\Wp\Interfaces\Services\Domain\UserServiceInterface;

class UserController implements UserControllerInterface {
	public function __construct(
		UserServiceInterface $user_service
	) {
		$this->user_service = $user_service;
	}
	
	public function index( $request ) {
		$params = $request->get_params();
		$users = $this->user_service->index( $params );
		return $users;
	}

	public function show( $request ) {
		$id = (string) $request['id'];
		if ( !$id ) {
			return;
		}
		$user = $this->user_service->show( $id );
		return $user;
	}
}
