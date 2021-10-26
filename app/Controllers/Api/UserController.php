<?php

namespace Tokenly\Wp\Controllers\Api;

use Tokenly\Wp\Repositories\UserRepository;

class UserController {
	public function __construct(
		UserRepository $user_repository
	) {
		$this->user_repository = $user_repository;
	}
	
	public function index( $request ) {
		$index_parameters = $request['index_parameters'] ?? null;
		$users = $this->user_repository->index( $index_parameters );
		error_log( print_r($users, true) );
		return $users;
	}
}
