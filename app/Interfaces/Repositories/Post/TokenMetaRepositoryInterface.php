<?php

namespace Tokenly\Wp\Interfaces\Repositories\Post;

use Tokenly\Wp\Interfaces\Models\TokenMetaInterface;

interface TokenMetaRepositoryInterface {
	public function index( array $params = array() );
	public function update( TokenMetaInterface $post, array $params = array() );
}
