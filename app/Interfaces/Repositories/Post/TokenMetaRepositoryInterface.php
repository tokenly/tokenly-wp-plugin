<?php

namespace Tokenly\Wp\Interfaces\Repositories\Post;

interface TokenMetaRepositoryInterface {
	public function index( $params );
	public function show( $post_id );
	public function update( $post_id, $params );
}
