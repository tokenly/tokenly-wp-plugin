<?php

namespace Tokenly\Wp;

use Tokenly\Wp\Controllers\AuthController;

class Router {
	public static $namespace     = 'tokenly/v1';

	public function __construct() {
		add_action( 'rest_api_init', array( $this, 'register_routes' ) );
	}

	public static function get_routes() {
		return [
			'authorize-callback' => [
				'path' => '/authorize/callback',
				'args' => array(
					'methods'             => 'GET',
					'callback'            => array( AuthController::class, 'authorize' ),
					'permission_callback' => '__return_true',
				),
			],
		];
	}

	public static function get_route_url( $route_key ) {
		$routes = self::get_routes();
		$route = $routes[ $route_key ] ?? null;
		if ( $route ) {
			return get_site_url() . '/wp-json/' . self::$namespace . $route['path'];
		}
	}
	
	public function register_routes() {
		$routes = self::get_routes();
		foreach ( $routes as $route ) {
			register_rest_route( self::$namespace, $route['path'], $route['args'] );
		}
	}
}
