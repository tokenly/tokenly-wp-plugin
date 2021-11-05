<?php

namespace Tokenly\Wp\Interfaces\Repositories\General;

interface UserMetaRepositoryInterface {
	public function index( $user_id, $keys );
	public function show( $user_id, $key );
	public function update( $user_id, $payload );
}
