<?php

namespace Tokenly\Wp\Routes;

use Tokenly\Wp\Controllers\Api\AuthController;
use Tokenly\Wp\Controllers\Api\SettingsController;

class ApiRouter {
	public $namespace = 'tokenly/v1';

	public function boot() {
		add_action( 'rest_api_init', array( $this, 'register_routes' ) );
	}

	public function get_routes() {
		return [
			'authorize' => array(
				'path' => '/authorize',
				'args' => array(
					'methods'             => 'GET',
					'callback'            => array( new AuthController(), 'authorize' ),
					'permission_callback' => '__return_true',
				),
			),
			'authorize-callback' => array(
				'path' => '/authorize/callback',
				'args' => array(
					'methods'             => 'GET',
					'callback'            => array( new AuthController(), 'authorize_callback' ),
					'permission_callback' => '__return_true',
				),
			),
			'settings-show' => array(
				'path' => '/settings',
				'args' => array(
					'methods'             => 'GET',
					'callback'            => array( new SettingsController(), 'show' ),
					'permission_callback' => function () {
						return current_user_can( 'manage_options' );
					},
				),
			),
			'settings-update' => array(
				'path' => '/settings',
				'args' => array(
					'methods'             => 'PUT',
					'callback'            => array( new SettingsController(), 'update' ),
					'permission_callback' => function () {
						return current_user_can( 'manage_options' );
					},
				),
			),
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
