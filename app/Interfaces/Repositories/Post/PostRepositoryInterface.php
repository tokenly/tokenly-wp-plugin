<?php

namespace Tokenly\Wp\Interfaces\Repositories\Post;

use Tokenly\Wp\Interfaces\Models\PostInterface;

interface PostRepositoryInterface {
	public function show( array $params = array() );
	public function update( PostInterface $post, array $params = array() );
}
