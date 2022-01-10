<?php

namespace Tokenly\Wp\Routes;

use Tokenly\Wp\Interfaces\Routes\RouterInterface;
use Tokenly\Wp\Services\Service;
use Twig\Environment;

/**
 * Base router
 */
class Router extends Service implements RouterInterface {
	protected $routes = array();
	protected $default_template;
	protected $middleware = array();

	/**
	 * Hooks the router to WordPress
	 */
	public function register() {
		$this->routes = $this->get_routes();
		$this->register_routes();
		$this->register_middleware();
	}
	
	/**
	 * Registers all middleware
	 */
	public function register_middleware() {
		foreach ( $this->middleware as $middleware ) {
			$middleware->register();
		}
	}

	/**
	 * Registers a single route
	 */
	public function register_route( string $key, array $route ) {
		//
	}

	/**
	 * Gets the shared data for each route
	 * @return array Shared data
	 */
	protected function get_shared_data() {
		return array(
			'nonce' =>  wp_create_nonce( 'wp_rest' ),
		);
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
	public function render_route( callable $render_function, array $arguments = array() ) {
		$controller_response = call_user_func( $render_function, ...$arguments );
		if ( !$controller_response ) {
			return;
		}
		$view_data = array();
		$shared_data = $this->get_shared_data();
		$view_data = array_merge( $view_data, $shared_data );
		$template = $this->default_template;
		if ( isset( $controller_response['template'] ) ) {
			$template = $controller_response['template'];
		}
		if ( isset( $controller_response['data'] ) && is_array( $controller_response['data'] ) ) {
			$view_data = array_merge( $view_data, $controller_response['data'] );
		}
		if ( isset( $controller_response['view'] ) ) {
			$view_data['view'] = $controller_response['view'];
		}
		if ( $template == 'Dynamic.twig' ) {
			$view_data = array(
				'props' => $view_data,
			);
		}
		$html = $this->twig->render( $template, $view_data );	
		echo $html;
	}
}
