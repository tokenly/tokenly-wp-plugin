<?php

namespace Tokenly\Wp\Repositories\Routes;

use Tokenly\Wp\Repositories\Repository;
use Tokenly\Wp\Interfaces\Repositories\Routes\RouteRepositoryInterface;

use Tokenly\Wp\Models\Routes\Route;
use Tokenly\Wp\Collections\Routes\RouteCollection;
use Tokenly\Wp\Interfaces\Collections\Routes\RouteCollectionInterface;

class RouteRepository extends Repository implements RouteRepositoryInterface {
	protected string $collection_class = RouteCollection::class;
	protected RouteCollectionInterface $routes;

	public function register( array $routes = array() ): void {
		$this->routes =
			( new $this->collection_class() )->from_array( $routes );
	}

	public function index(): RouteCollectionInterface {
		return $this->routes;
	}

	public function index_formatted(): array {
		return array();
	}

	public function get_can_register( $route ): bool {
		$can_register = true;
		if ( property_exists( $route, 'policy' ) && $route->policy ) {
			if ( is_array( $route->policy ) ) {
				$can_register = call_user_func(
					array( $route->policy[0], 'before' )
				);
				if (
					$can_register === false &&
					method_exists( $route->policy[0], $route->policy[1] )
				) {
					$can_register = call_user_func( $route->policy );
				}
			} else {
				$can_register = call_user_func( $route->policy );
			}
		} else {
			$can_register = true;
		}
		if ( !$can_register ) {
			$can_register = false;
		}
		return $can_register;
	}
}
