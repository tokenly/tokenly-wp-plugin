<?php

namespace Tokenly\Wp\Interfaces\Repositories\General;

interface PostMetaRepositoryInterface {
	public function index( $post_id, $keys );
	public function show( $post_id, $key );
	public function update( $post_id, $payload );
}
