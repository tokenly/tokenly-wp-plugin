<?php

namespace Tokenly\Wp\Repositories\Routes;

use Tokenly\Wp\Repositories\Routes\RouteRepository;
use Tokenly\Wp\Interfaces\Repositories\Routes\ApiRouteRepositoryInterface;

use Tokenly\Wp\Collections\Routes\ApiRouteCollection;

class ApiRouteRepository extends RouteRepository implements ApiRouteRepositoryInterface {
	protected string $collection_class = ApiRouteCollection::class; 

	public function index_formatted(): array {
		$formatted = array();
		foreach ( $this->routes as $route_key => $route ) {
			$path = $route->path;
			$formatted[ $route_key ] = array(
				'url'  => "/wp-json/tokenly/v1{$path}",
			);
		}
		return $formatted;
	}
}
