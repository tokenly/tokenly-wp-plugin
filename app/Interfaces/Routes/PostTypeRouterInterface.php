<?php

namespace Tokenly\Wp\Interfaces\Routes;

interface PostTypeRouterInterface {
	public function register();
	public function get_routes();
	public function register_routes();
	public function on_post_save( $post_id, $post, $update );
}
