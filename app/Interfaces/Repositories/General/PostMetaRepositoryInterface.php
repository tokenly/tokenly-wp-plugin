<?php

namespace Tokenly\Wp\Interfaces\Repositories\General;

interface PostMetaRepositoryInterface {
	public function index( int $post_id, array $keys );
	public function show( int $post_id, string $key );
	public function update( int $post_id, array $payload );
}
