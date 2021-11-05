<?php

namespace Tokenly\Wp\Interfaces\Services\Post;

interface TokenMetaRepositoryInterface {
	public function index( $params );
	public function show( $post_id );
	public function update( $post_id, $params );
}
