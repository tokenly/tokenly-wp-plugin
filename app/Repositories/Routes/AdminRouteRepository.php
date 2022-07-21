<?php

namespace Tokenly\Wp\Repositories\Routes;

use Tokenly\Wp\Repositories\Routes\RouteRepository;
use Tokenly\Wp\Interfaces\Repositories\Routes\AdminRouteRepositoryInterface;

use Tokenly\Wp\Collections\Routes\AdminRouteCollection;

class AdminRouteRepository extends RouteRepository implements AdminRouteRepositoryInterface {
	protected string $collection_class = AdminRouteCollection::class; 

	public function index_formatted(): array {
		$formatted = array();
		foreach ( $this->routes as $route_key => $route ) {
			$can_register = $this->get_can_register( $route );
			$route_menu_slug = $route->menu_slug;
			$formatted[ "{$route_key}" ] = array(
				'name' => $route->menu_title,
				'url'  => "/wp-admin/admin.php?page={$route_menu_slug}",
				'access' => $can_register,
			);
			if ( !$route->subroutes ) {
				continue;
			}
			foreach ( $route->subroutes as $subroute_key => $subroute ) {
				$can_register = $this->get_can_register( $subroute );
				$subroute_menu_slug = $subroute->menu_slug;
				$formatted[ "{$route_key}_{$subroute_key}" ] = array(
					'name' => $subroute->menu_title,
					'url'  => "/wp-admin/admin.php?page={$subroute_menu_slug}",
					'access' => $can_register,
				);
			}
		}
		return $formatted;
	}
}
