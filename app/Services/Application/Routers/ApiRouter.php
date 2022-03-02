<?php

namespace Tokenly\Wp\Services\Application\Routers;

use Tokenly\Wp\Services\Application\Routers\Router;
use Tokenly\Wp\Interfaces\Services\Application\Routers\ApiRouterInterface;

use Tokenly\Wp\Interfaces\Repositories\Routes\ApiRouteRepositoryInterface;
use Tokenly\Wp\Interfaces\Models\Routes\RouteInterface;
use Tokenly\Wp\Interfaces\Collections\Routes\RouteCollectionInterface;

/**
 * Manages routing for the REST API endpoints
 */
class ApiRouter extends Router implements ApiRouterInterface {
	protected string $api_namespace;
	protected ApiRouteRepositoryInterface $api_route_repository;

	public function __construct(
		string $namespace,
		ApiRouteRepositoryInterface $api_route_repository
	) {
		parent::__construct( $namespace );
		$this->api_route_repository = $api_route_repository;
		$this->api_namespace = "{$this->namespace}/v1";
	}

	/**
	 * @inheritDoc
	 */
	public function register(): void {
		$this->routes = $this->api_route_repository->index();
		$this->routes = $this->process_routes( $this->routes );
		add_action( 'rest_api_init', array( $this, 'register_routes' ) );
	}

	/**
	 * @inheritDoc
	 */
	public function register_routes(): void {
		foreach ( ( array ) $this->routes as $route ) {
			$args = $route->get_register_arguments();
			register_rest_route( $this->api_namespace, ...$args );
		}
	}

	/**
	 * @inheritDoc
	 */
	protected function process_routes( RouteCollectionInterface $routes ): RouteCollectionInterface {
		foreach ( ( array ) $routes as $key => $route ) {
			$callback = $route->get_callback();
			$route->set_callback( function( $request ) use ( $callback ) {
				if ( is_array( $callback ) ) {
					$controller = $callback[0];
					$method = $callback[1];
					if ( method_exists( $controller, 'call' ) ) {
						return call_user_func( array( $controller, 'call' ), $request, $method );
					} else {
						return call_user_func( $callback, $request );
					}
				} else {
					return call_user_func( $callback, $request );
				}
			} );
			$routes[ $key ] = $route;
		}
		return $routes;
	}
}
