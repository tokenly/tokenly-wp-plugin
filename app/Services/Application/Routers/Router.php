<?php

namespace Tokenly\Wp\Services\Application\Routers;

use Tokenly\Wp\Services\Service;
use Tokenly\Wp\Interfaces\Services\Application\Routers\RouterInterface;

use Tokenly\Wp\Interfaces\Collections\CollectionInterface;
use Tokenly\Wp\Interfaces\Models\Routes\RouteInterface;
use Tokenly\Wp\Interfaces\Collections\Routes\RouteCollectionInterface;

/**
 * Base router
 */
class Router extends Service implements RouterInterface {
	protected RouteCollectionInterface $routes;
	protected string $default_template;
	protected string $namespace;
	protected array $Service = array();

	public function __construct( string $namespace ) {
		$this->namespace = $namespace;
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

	/**
	 * Executes the specified render callback
	 * @param callable $render_function Controller's render function
	 * @return void
	 */
	public function render_route(
		callable $render_function,
		array $arguments = array()
	): void {
		$response = call_user_func( $render_function, ...$arguments );
		if ( !$response ) {
			return;
		}
		$view_data = array();
		$template = $this->default_template;
		if ( isset( $response['view'] ) ) {
			$view_data['view'] = $response['view'];
		}
		if ( isset( $response['template'] ) ) {
			$template = $response['template'];
		}
		$props = array();
		if ( isset( $response['data'] ) ) {
			$props = $response['data'];
		}
		if ( $template == 'Dynamic.twig' ) {
			$props = htmlspecialchars(
				json_encode( $props ),
				ENT_QUOTES,
				'UTF-8'
			);
		}
		$view_data['props'] = $props;
		$view_data['namespace'] = $this->namespace;
		$html = $this->twig->render( $template, $view_data );	
		echo $html;
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
