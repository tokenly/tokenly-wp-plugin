<?php

namespace Tokenly\Wp\Interfaces\Routes;

interface PostTypeRouterInterface {
	public function register();
	public function on_post_save( int $post_id, \WP_Post $post, bool $update );
}
