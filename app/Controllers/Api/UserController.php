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
		$index_parameters = $request['index_parameters'];
		if ( $index_parameters ) {
			$index_parameters = json_decode( $index_parameters, true );
		} else {
			$index_parameters = array();
		}
		$users = $this->user_repository->index( $index_parameters );
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
