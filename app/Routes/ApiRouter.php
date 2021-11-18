<?php

namespace Tokenly\Wp\Routes;

use Tokenly\Wp\Interfaces\Routes\ApiRouterInterface;
use Tokenly\Wp\Interfaces\Controllers\Api\AuthControllerInterface;
use Tokenly\Wp\Interfaces\Controllers\Api\SettingsControllerInterface;
use Tokenly\Wp\Interfaces\Controllers\Api\WhitelistControllerInterface;
use Tokenly\Wp\Interfaces\Controllers\Api\PromiseControllerInterface;
use Tokenly\Wp\Interfaces\Controllers\Api\UserControllerInterface;
use Tokenly\Wp\Interfaces\Controllers\Api\SourceControllerInterface;

/**
 * Manages routing for the REST API endpoints
 */
class ApiRouter implements ApiRouterInterface {
	protected $namespace = 'tokenly/v1';
	protected $controllers = array();

	public function __construct(
		AuthControllerInterface $auth_controller,
		SettingsControllerInterface $settings_controller,
		WhitelistControllerInterface $whitelist_controller,
		PromiseControllerInterface $promise_controller,
		SourceControllerInterface $source_controller,
		UserControllerInterface $user_controller
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

	/**
	 * Registers the router
	 * @return void
	 */
	public function register() {
		add_action( 'rest_api_init', array( $this, 'register_routes' ) );
	}

	/**
	 * Registers all routes
	 * @return void
	 */
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

	/**
	 * Gets all route definitions
	 * @return array
	 */
	protected function get_routes() {
		return array(
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
			'promise-update' => array(
				'path' => '/promise/(?P<promise>[\d]+)',
				'args' => array(
					'methods'             => 'PUT',
					'callback'            => array( $this->controllers['promise'], 'update' ),
					'permission_callback' => function () {
						return current_user_can( 'manage_options' );
					},
				),
			),
			'promise-destroy' => array(
				'path' => '/promise/(?P<promise>[\d]+)',
				'args' => array(
					'methods'             => 'DELETE',
					'callback'            => array( $this->controllers['promise'], 'destroy' ),
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
			'source-update' => array(
				'path' => '/source/(?P<address>[a-zA-Z0-9-]+)',
				'args' => array(
					'methods'             => 'PUT',
					'callback'            => array( $this->controllers['source'], 'update' ),
					'permission_callback' => function () {
						return current_user_can( 'manage_options' );
					},
				),
			),
			'source-destroy' => array(
				'path' => '/source/(?P<address>[a-zA-Z0-9-]+)',
				'args' => array(
					'methods'             => 'DELETE',
					'callback'            => array( $this->controllers['source'], 'destroy' ),
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
		);
	}
	
	/**
	 * Get all route urls
	 * @return array
	 */
	protected function get_route_urls() {
		$routes = $this->get_routes();
		$urls = array();
		$base = get_site_url() . '/wp-json/' . $this->namespace;
		foreach ( $routes as $key => $route ) {
			$urls[ $key ] = $base . $route['path'];
		}
		return $urls;
	}
}
