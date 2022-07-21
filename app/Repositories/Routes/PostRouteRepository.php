<?php

namespace Tokenly\Wp\Repositories\Routes;

use Tokenly\Wp\Repositories\Routes\RouteRepository;
use Tokenly\Wp\Interfaces\Repositories\Routes\PostRouteRepositoryInterface;

use Tokenly\Wp\Collections\Routes\PostRouteCollection;

class PostRouteRepository extends RouteRepository implements PostRouteRepositoryInterface {
	protected string $collection_class = PostRouteCollection::class;

	public function index_formatted(): array {
		$formatted = array();
		foreach ( $this->routes as $route_key => $route ) {
			$urls = array();
			$id = $route->id;
			$can_register = $this->get_can_register( $route );
			$post_types = $route->post_type;
			if ( !$post_types ) {
				$post_types = get_post_types() ?? array();
			}
			foreach ( $post_types as $post_type ) {
				$url = "/wp-admin/edit.php?post_type={$post_type}";
				$urls[ "{$id}_{$post_type}" ] = array(
					'url'    => $url,
					'access' => $can_register,
				);
			}
			$formatted = array_merge( $formatted, $urls );
		}
		return $formatted;
	}
}
