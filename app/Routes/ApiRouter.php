<?php

namespace Tokenly\Wp\Routes;

use Tokenly\Wp\Controllers\Api\AuthController;
use Tokenly\Wp\Controllers\Api\SettingsController;
use Tokenly\Wp\Controllers\Api\WhitelistController;
use Tokenly\Wp\Controllers\Api\PromiseController;
use Tokenly\Wp\Controllers\Api\UserController;
use Tokenly\Wp\Controllers\Api\SourceController;

class ApiRouter {
	public $namespace = 'tokenly/v1';
	public $controllers = array();

	public function __construct(
		AuthController $auth_controller,
		SettingsController $settings_controller,
		WhitelistController $whitelist_controller,
		PromiseController $promise_controller,
		SourceController $source_controller,
		UserController $user_controller
	) {
		$this->controllers = array(
			'auth'       => $auth_controller,
			'settings'   => $settings_controller,
			'whitelist'  => $whitelist_controller,
			'promise'    => $promise_controller,
			'source'     => $source_controller,
			'user'       => $user_controller,
		);
		global $tokenly_routes;
		$tokenly_routes['api'] = $this->get_route_urls();
	}

	public function register() {
		add_action( 'rest_api_init', array( $this, 'register_routes' ) );
	}

	public function get_routes() {
		return [
			'authorize-status' => array(
				'path' => '/authorize',
				'args' => array(
					'methods'             => 'GET',
					'callback'            => array( $this->controllers['auth'], 'status' ),
					'permission_callback' => function () {
						return current_user_can( 'read' );
					},
				),
			),
			'authorize-connect' => array(
				'path' => '/authorize',
				'args' => array(
					'methods'             => 'POST',
					'callback'            => array( $this->controllers['auth'], 'authorize' ),
					'permission_callback' => '__return_true',
				),
			),
			'authorize-disconnect' => array(
				'path' => '/authorize',
				'args' => array(
					'methods'             => 'DELETE',
					'callback'            => array( $this->controllers['auth'], 'disconnect' ),
					'permission_callback' => function () {
						return current_user_can( 'read' );
					},
				),
			),
			'settings-show' => array(
				'path' => '/settings',
				'args' => array(
					'methods'             => 'GET',
					'callback'            => array( $this->controllers['settings'], 'show' ),
					'permission_callback' => function () {
						return current_user_can( 'manage_options' );
					},
				),
			),
			'settings-update' => array(
				'path' => '/settings',
				'args' => array(
					'methods'             => 'PUT',
					'callback'            => array( $this->controllers['settings'], 'update' ),
					'permission_callback' => function () {
						return current_user_can( 'manage_options' );
					},
				),
				'schema' => array( $this->controllers['settings'], 'get_update_schema' ),
			),
			'whitelist-show' => array(
				'path' => '/whitelist',
				'args' => array(
					'methods'             => 'GET',
					'callback'            => array( $this->controllers['whitelist'], 'show' ),
					'permission_callback' => function () {
						return current_user_can( 'manage_options' );
					},
				),
			),
			'whitelist-update' => array(
				'path' => '/whitelist',
				'args' => array(
					'methods'             => 'PUT',
					'callback'            => array( $this->controllers['whitelist'], 'update' ),
					'permission_callback' => function () {
						return current_user_can( 'manage_options' );
					},
				),
			),
			'promise-index' => array(
				'path' => '/promise',
				'args' => array(
					'methods'             => 'GET',
					'callback'            => array( $this->controllers['promise'], 'index' ),
					'permission_callback' => function () {
						return current_user_can( 'manage_options' );
					},
				),
			),
			'promise-store' => array(
				'path' => '/promise',
				'args' => array(
					'methods'             => 'POST',
					'callback'            => array( $this->controllers['promise'], 'store' ),
					'permission_callback' => function () {
						return current_user_can( 'manage_options' );
					},
				),
			),
			'source-index' => array(
				'path' => '/source',
				'args' => array(
					'methods'             => 'GET',
					'callback'            => array( $this->controllers['source'], 'index' ),
					'permission_callback' => function () {
						return current_user_can( 'manage_options' );
					},
				),
			),
			'source-store' => array(
				'path' => '/source',
				'args' => array(
					'methods'             => 'POST',
					'callback'            => array( $this->controllers['source'], 'store' ),
					'permission_callback' => function () {
						return current_user_can( 'manage_options' );
					},
				),
			),
			'user-index' => array(
				'path' => '/user',
				'args' => array(
					'methods'             => 'GET',
					'callback'            => array( $this->controllers['user'], 'index' ),
					'permission_callback' => function () {
						return current_user_can( 'manage_options' );
					},
				),
			),
			'user-show' => array(
				'path' => '/user/(?P<id>[\d]+)',
				'args' => array(
					'methods'             => 'GET',
					'callback'            => array( $this->controllers['user'], 'show' ),
					'permission_callback' => function () {
						return current_user_can( 'manage_options' );
					},
				),
			),
		];
	}
	

	public function get_route_urls() {
		$routes = $this->get_routes();
		$urls = array();
		$base = get_site_url() . '/wp-json/' . $this->namespace;
		foreach ( $routes as $key => $route ) {
			$urls[ $key ] = $base . $route['path'];
		}
		return $urls;
	}
	
	public function register_routes() {
		$routes = $this->get_routes();
		foreach ( $routes as $route ) {
			$path = $route['path'] ?? null;
			$args = $route['args'] ?? null;
			$schema = $route['schema'] ?? null;
			register_rest_route(
				$this->namespace,
				$path,
				array(
					$args,
					'schema' => $schema,
				)
			);
		}
	}
}
