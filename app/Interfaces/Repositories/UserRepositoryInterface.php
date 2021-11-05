<?php

namespace Tokenly\Wp\Interfaces\Services;

interface UserRepositoryInterface {
	public function index( $params );
	public function show( $user_id = 0 );
}
