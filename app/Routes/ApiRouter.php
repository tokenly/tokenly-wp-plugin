<?php

namespace Tokenly\Wp\Routes;

use Tokenly\Wp\Interfaces\Routes\ApiRouterInterface;
use Tokenly\Wp\Interfaces\Controllers\Api\AuthControllerInterface;
use Tokenly\Wp\Interfaces\Controllers\Api\IntegrationSettingsControllerInterface;
use Tokenly\Wp\Interfaces\Controllers\Api\TcaSettingsControllerInterface;
use Tokenly\Wp\Interfaces\Controllers\Api\WhitelistControllerInterface;
use Tokenly\Wp\Interfaces\Controllers\Api\PromiseControllerInterface;
use Tokenly\Wp\Interfaces\Controllers\Api\CreditGroupControllerInterface;
use Tokenly\Wp\Interfaces\Controllers\Api\UserControllerInterface;
use Tokenly\Wp\Interfaces\Controllers\Api\SourceControllerInterface;
use Tokenly\Wp\Routes\Router;

/**
 * Manages routing for the REST API endpoints
 */
class ApiRouter extends Router implements ApiRouterInterface {
	protected $namespace;
	protected $api_namespace;
	protected $controllers = array();

	public function __construct(
		AuthControllerInterface $auth_controller,
		IntegrationSettingsControllerInterface $settings_integration_controller,
		TcaSettingsControllerInterface $settings_tca_controller,
		WhitelistControllerInterface $whitelist_controller,
		PromiseControllerInterface $promise_controller,
		CreditGroupControllerInterface $credit_group,
		SourceControllerInterface $source_controller,
		UserControllerInterface $user_controller,
		string $namespace
	) {
		$this->namespace = $namespace;
		$this->api_namespace = "{$this->namespace}/v1";
		$this->controllers = array(
			'auth'                   => $auth_controller,
			'settings-integration'   => $settings_integration_controller,
			'settings-tca'           => $settings_tca_controller,
			'whitelist'              => $whitelist_controller,
			'credit-group'           => $credit_group,
			'promise'                => $promise_controller,
			'source'                 => $source_controller,
			'user'                   => $user_controller,
		);
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
				$this->api_namespace,
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
					'callback'            => array( $this->controllers['auth'], 'show' ),
					'permission_callback' => function () {
						return current_user_can( 'read' );
					},
				),
			),
			'settings-integration-show' => array(
				'path' => '/settings/integration',
				'args' => array(
					'methods'             => 'GET',
					'callback'            => array( $this->controllers['settings-integration'], 'show' ),
					'permission_callback' => function () {
						return current_user_can( 'manage_options' );
					},
				),
			),
			'settings-integration-update' => array(
				'path' => '/settings/integration',
				'args' => array(
					'methods'             => 'PUT',
					'callback'            => array( $this->controllers['settings-integration'], 'update' ),
					'permission_callback' => function () {
						return current_user_can( 'manage_options' );
					},
				),
			),
			'settings-tca-show' => array(
				'path' => '/settings/tca',
				'args' => array(
					'methods'             => 'GET',
					'callback'            => array( $this->controllers['settings-tca'], 'show' ),
					'permission_callback' => function () {
						return current_user_can( 'manage_options' );
					},
				),
			),
			'settings-tca-update' => array(
				'path' => '/settings/tca',
				'args' => array(
					'methods'             => 'PUT',
					'callback'            => array( $this->controllers['settings-tca'], 'update' ),
					'permission_callback' => function () {
						return current_user_can( 'manage_options' );
					},
				),
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
			'credit-group-index' => array(
				'path' => '/credit-group',
				'args' => array(
					'methods'             => 'GET',
					'callback'            => array( $this->controllers['credit-group'], 'index' ),
					'permission_callback' => function () {
						return current_user_can( 'manage_options' );
					},
				),
			),
			'credit-group-store' => array(
				'path' => '/credit-group',
				'args' => array(
					'methods'             => 'POST',
					'callback'            => array( $this->controllers['credit-group'], 'store' ),
					'permission_callback' => function () {
						return current_user_can( 'manage_options' );
					},
				),
			),
			'credit-group-update' => array(
				'path' => '/credit-group',
				'args' => array(
					'methods'             => 'PUT',
					'callback'            => array( $this->controllers['credit-group'], 'update' ),
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
}
