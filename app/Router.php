<?php

namespace Tokenly\Wp;

use Tokenly\Wp\Controllers\AuthController;

class Router {
	public $namespace = 'tokenly/v1';

	public function __construct() {
		//
	}

	public function init() {
		add_action( 'rest_api_init', array( $this, 'register_routes' ) );
	}

	public function get_routes() {
		return [
			'authorize' => [
				'path' => '/authorize',
				'args' => array(
					'methods'             => 'GET',
					'callback'            => array( new AuthController(), 'authorize' ),
					'permission_callback' => '__return_true',
				),
			],
			'authorize-callback' => [
				'path' => '/authorize/callback',
				'args' => array(
					'methods'             => 'GET',
					'callback'            => array( new AuthController(), 'authorize_callback' ),
					'permission_callback' => '__return_true',
				),
			],
		];
	}

	public function get_route_url( $route_key ) {
		$routes = $this->get_routes();
		$route = $routes[ $route_key ] ?? null;
		if ( $route ) {
			return get_site_url() . '/wp-json/' . $this->namespace . $route['path'];
		}
	}
	
	public function register_routes() {
		$routes = $this->get_routes();
		foreach ( $routes as $route ) {
			register_rest_route( $this->namespace, $route['path'], $route['args'] );
		}
	}
}
