<?php

namespace Tokenly\Wp\Routes;

use Tokenly\Wp\Interfaces\Routes\RouterInterface;

/**
 * Base router
 */
class Router implements RouterInterface {
	protected $routes = array();

	/**
	 * Hooks the router to WordPress
	 */
	public function register() {
		//
	}

	/**
	 * Registers a single route
	 */
	public function register_route( string $key, array $route ) {
		//
	}

	/**
	 * Hooks the router to WordPress
	 */
	public function register_routes() {
		foreach ( $this->routes as $key => $route ) {
			$this->register_route( $key, $route );
		}
	}

	/**
	 * Executes the specified render callback
	 * @param callable $render_function Controller's render function
	 */
	public function render_route( callable $render_function ) {
		$html = call_user_func( $render_function );	
		echo $html;
	}
}
