<?php

namespace Tokenly\Wp\Interfaces\Repositories\Post;

interface TokenMetaRepositoryInterface {
	public function index( array $params = array() );
	public function show(  array $params = array() );
	public function update( int $post_id, array $params = array() );
}
