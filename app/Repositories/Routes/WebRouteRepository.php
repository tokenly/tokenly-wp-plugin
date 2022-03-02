<?php

namespace Tokenly\Wp\Repositories\Routes;

use Tokenly\Wp\Repositories\Routes\RouteRepository;
use Tokenly\Wp\Interfaces\Repositories\Routes\WebRouteRepositoryInterface;

use Tokenly\Wp\Collections\Routes\WebRouteCollection;

class WebRouteRepository extends RouteRepository implements WebRouteRepositoryInterface {
	protected string $collection_class = WebRouteCollection::class;

	public function index_formatted(): array {
		$formatted = array();
		foreach ( $this->routes as $route ) {
			$path = $route->get_path();
			$id = $route->get_id();
			$formatted[ $id ] = array(
				'url'  => $path,
			);
		}
		return $formatted;
	}
}
