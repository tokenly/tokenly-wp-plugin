<?php

namespace Tokenly\Wp\Interfaces\Routes;

use Tokenly\Wp\Interfaces\Routes\RouterInterface;

interface PostTypeRouterInterface extends RouterInterface {
	public function on_post_save( int $post_id, \WP_Post $post, bool $update );
}
