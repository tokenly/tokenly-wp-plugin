<?php

namespace Tokenly\Wp\Interfaces\Repositories\General;

interface UserMetaRepositoryInterface {
	public function index( int $user_id, string ...$keys );
	public function show( int $user_id, string $key );
	public function update( int $user_id, array $payload );
	public function destroy( int $user_id, ...$keys );
}
