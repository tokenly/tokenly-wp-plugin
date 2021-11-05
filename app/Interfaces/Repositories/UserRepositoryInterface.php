<?php

namespace Tokenly\Wp\Interfaces\Repositories;

interface UserRepositoryInterface {
	public function index( $params );
	public function show( $user_id = 0 );
}
