<?php

namespace Tokenly\Wp\Repositories\Routes;

use Tokenly\Wp\Repositories\Routes\RouteRepository;
use Tokenly\Wp\Interfaces\Repositories\Routes\TermRouteRepositoryInterface;

use Tokenly\Wp\Collections\Routes\TermRouteCollection;

class TermRouteRepository extends RouteRepository implements TermRouteRepositoryInterface {
	protected string $collection_class = TermRouteCollection::class;

	public function index_formatted(): array {
		$formatted = array();
		foreach ( $this->routes as $route_key => $route ) {
			$urls = array();
			$id = $route->id;
			$can_register = $this->get_can_register( $route );
			$taxonomies = $route->taxonomy;
			if ( !$taxonomies ) {
				$taxonomies = get_taxonomies() ?? array();
			}
			foreach ( $taxonomies as $taxonomy ) {
				$urls[ "{$id}_{$taxonomy}" ] = array(
					'url'    => "/wp-admin/edit-tags.php?taxonomy={$taxonomy}",
					'access' => $can_register,
				);
			}
			$formatted = array_merge( $formatted, $urls );
		}
		return $formatted;
	}
}
