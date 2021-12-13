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
		$controller_response = call_user_func( $render_function );
		if ( !$controller_response ) {
			return;
		}
		$view_data = array();
		$template = $this->default_template;
		if ( isset( $controller_response['template'] ) ) {
			$template = $controller_response['template'];
		}
		if ( isset( $controller_response['data'] ) ) {
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
