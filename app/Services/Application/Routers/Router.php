<?php

namespace Tokenly\Wp\Services\Application\Routers;

use Tokenly\Wp\Services\Service;
use Tokenly\Wp\Interfaces\Services\Application\Routers\RouterInterface;

use Tokenly\Wp\Interfaces\Collections\CollectionInterface;
use Tokenly\Wp\Interfaces\Models\Routes\RouteInterface;
use Tokenly\Wp\Interfaces\Collections\Routes\RouteCollectionInterface;
use Tokenly\Wp\Interfaces\Services\Application\ViewRendererInterface;

/**
 * Base router
 */
class Router extends Service implements RouterInterface {
	protected RouteCollectionInterface $routes;
	protected string $default_template;
	protected string $namespace;
	protected ?ViewRendererInterface $view_renderer;

	public function __construct(
		string $namespace,
		?ViewRendererInterface $view_renderer = null
	) {
		$this->namespace = $namespace;
		$this->view_renderer = $view_renderer;
	}

	/**
	 * Makes the route data suitable for registration
	 * @param RouteCollectionInterface $routes Routes to process
	 * @return RouteCollectionInterface $routes Formatted route data
	 */
	protected function process_routes(
		RouteCollectionInterface $routes
	): RouteCollectionInterface {
		return $routes;
	}

	protected function render(
		callable $render_function,
		array $arguments = array()
	) {
		$this->view_renderer->render(
			$render_function, $arguments, $this->default_template
		);
	}
	
	/**
	 * Checks if the conditions for route registration are met
	 * @param string $route Route key
	 * @return bool
	 */
	protected function can_register( RouteInterface $route ): bool {
		return false;
	}

	protected function request_params_present(): bool {
		if ( isset( $_POST[ "{$this->namespace}_data" ] ) ) {
			return true;
		} else {
			return false;
		}
	}

	protected function get_request_params(): array {
		$params = array();
		if ( $this->request_params_present() ) {
			$params = $_POST[ "{$this->namespace}_data" ];
			$params = wp_unslash( $params );
			$params = json_decode( $params, true );
		}
		return $params;
	}
}
