<?php

namespace Tokenly\Wp\Routes;

use Tokenly\Wp\Routes\Router;
use Tokenly\Wp\Interfaces\Routes\ApiRouterInterface;
use Tokenly\Wp\Interfaces\Controllers\Api\AuthControllerInterface;
use Tokenly\Wp\Interfaces\Controllers\Api\UserControllerInterface;
use Tokenly\Wp\Interfaces\Controllers\Api\Credit\GroupControllerInterface as CreditGroupControllerInterface;
use Tokenly\Wp\Interfaces\Controllers\Api\Credit\TransactionControllerInterface as CreditTransactionControllerInterface;
use Tokenly\Wp\Interfaces\Controllers\Api\Token\AddressControllerInterface as TokenAddressControllerInterface;
use Tokenly\Wp\Interfaces\Controllers\Api\Token\PromiseControllerInterface as TokenPromiseControllerInterface;
use Tokenly\Wp\Interfaces\Controllers\Api\Token\SourceControllerInterface as TokenSourceControllerInterface;
use Tokenly\Wp\Interfaces\Controllers\Api\SettingsControllerInterface;

/**
 * Manages routing for the REST API endpoints
 */
class ApiRouter extends Router implements ApiRouterInterface {
	protected $namespace;
	protected $api_namespace;
	protected $controllers = array();

	public function __construct(
		AuthControllerInterface $auth_controller,
		CreditGroupControllerInterface $credit_group_controller,
		CreditTransactionControllerInterface $credit_transaction_controller,
		TokenAddressControllerInterface $token_address_controller,
		TokenPromiseControllerInterface $token_promise_controller,
		TokenSourceControllerInterface $token_source_controller,
		SettingsControllerInterface $settings_controller,
		UserControllerInterface $user_controller,
		string $namespace
	) {
		$this->namespace = $namespace;
		$this->api_namespace = "{$this->namespace}/v1";
		$this->controllers = array(
			'auth'                     => $auth_controller,
			'credit_group'             => $credit_group_controller,
			'credit_transaction'       => $credit_transaction_controller,
			'token_address'            => $token_address_controller,
			'token_promise'            => $token_promise_controller,
			'token_source'             => $token_source_controller,
			'settings'                 => $settings_controller,
			'user'                     => $user_controller,
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
		$routes = array(
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
			'credit_group_index' => array(
				'path' => '/credit/group',
				'args' => array(
					'methods'             => 'GET',
					'callback'            => array( $this->controllers['credit_group'], 'index' ),
					'permission_callback' => function () {
						return current_user_can( 'manage_options' );
					},
				),
			),
			'credit_group_show' => array(
				'path' => '/credit/group/(?P<group>\S+)',
				'args' => array(
					'methods'             => 'GET',
					'callback'            => array( $this->controllers['credit_group'], 'show' ),
					'permission_callback' => function () {
						return current_user_can( 'manage_options' );
					},
				),
			),
			'credit_group_store' => array(
				'path' => '/credit/group',
				'args' => array(
					'methods'             => 'POST',
					'callback'            => array( $this->controllers['credit_group'], 'store' ),
					'permission_callback' => function () {
						return current_user_can( 'manage_options' );
					},
				),
			),
			'credit_group_update' => array(
				'path' => '/credit/group/(?P<group>\S+)',
				'args' => array(
					'methods'             => 'PUT',
					'callback'            => array( $this->controllers['credit_group'], 'update' ),
					'permission_callback' => function () {
						return current_user_can( 'manage_options' );
					},
				),
			),
			'credit_transaction_index' => array(
				'path' => '/credit/transaction',
				'args' => array(
					'methods'             => 'GET',
					'callback'            => array( $this->controllers['credit_transaction'], 'index' ),
					'permission_callback' => function () {
						return current_user_can( 'manage_options' );
					},
				),
			),
			'credit_transaction_store' => array(
				'path' => '/credit/transaction',
				'args' => array(
					'methods'             => 'POST',
					'callback'            => array( $this->controllers['credit_transaction'], 'store' ),
					'permission_callback' => function () {
						return current_user_can( 'manage_options' );
					},
				),
			),
			'token_address_index' => array(
				'path' => '/token/address',
				'args' => array(
					'methods'             => 'GET',
					'callback'            => array( $this->controllers['token_address'], 'index' ),
					'permission_callback' => function () {
						return current_user_can( 'manage_options' );
					},
				),
			),
			'token_address_balance_index' => array(
				'path' => '/token/address/(?P<id>\S+)/balance',
				'args' => array(
					'methods'             => 'GET',
					'callback'            => array( $this->controllers['token_address'], 'balance_index' ),
					'permission_callback' => function () {
						return current_user_can( 'manage_options' );
					},
				),
			),
			'token_address_show' => array(
				'path' => '/token/address/(?P<id>\S+)',
				'args' => array(
					'methods'             => 'GET',
					'callback'            => array( $this->controllers['token_address'], 'show' ),
					'permission_callback' => function () {
						return current_user_can( 'manage_options' );
					},
				),
			),
			'token_promise_index' => array(
				'path' => '/token/promise',
				'args' => array(
					'methods'             => 'GET',
					'callback'            => array( $this->controllers['token_promise'], 'index' ),
					'permission_callback' => function () {
						return current_user_can( 'manage_options' );
					},
				),
			),
			'token_promise_show' => array(
				'path' => '/token/promise/(?P<promise>[\d]+)',
				'args' => array(
					'methods'             => 'GET',
					'callback'            => array( $this->controllers['token_promise'], 'show' ),
					'permission_callback' => function () {
						return current_user_can( 'manage_options' );
					},
				),
			),
			'token_promise_store' => array(
				'path' => '/token/promise',
				'args' => array(
					'methods'             => 'POST',
					'callback'            => array( $this->controllers['token_promise'], 'store' ),
					'permission_callback' => function () {
						return current_user_can( 'manage_options' );
					},
				),
			),
			'token_promise_update' => array(
				'path' => '/token/promise/(?P<promise>[\d]+)',
				'args' => array(
					'methods'             => 'PUT',
					'callback'            => array( $this->controllers['token_promise'], 'update' ),
					'permission_callback' => function () {
						return current_user_can( 'manage_options' );
					},
				),
			),
			'token_promise_destroy' => array(
				'path' => '/token/promise/(?P<promise>[\d]+)',
				'args' => array(
					'methods'             => 'DELETE',
					'callback'            => array( $this->controllers['token_promise'], 'destroy' ),
					'permission_callback' => function () {
						return current_user_can( 'manage_options' );
					},
				),
			),
			'token_source_index' => array(
				'path' => '/token/source',
				'args' => array(
					'methods'             => 'GET',
					'callback'            => array( $this->controllers['token_source'], 'index' ),
					'permission_callback' => function () {
						return current_user_can( 'manage_options' );
					},
				),
			),
			'token_source_show' => array(
				'path' => '/token/source/(?P<source>\S+)',
				'args' => array(
					'methods'             => 'GET',
					'callback'            => array( $this->controllers['token_source'], 'show' ),
					'permission_callback' => function () {
						return current_user_can( 'manage_options' );
					},
				),
			),
			'token_source_store' => array(
				'path' => '/token/source',
				'args' => array(
					'methods'             => 'POST',
					'callback'            => array( $this->controllers['token_source'], 'store' ),
					'permission_callback' => function () {
						return current_user_can( 'manage_options' );
					},
				),
			),
			'token_source_update' => array(
				'path' => '/token/source/(?P<source>\S+)',
				'args' => array(
					'methods'             => 'PUT',
					'callback'            => array( $this->controllers['token_source'], 'update' ),
					'permission_callback' => function () {
						return current_user_can( 'manage_options' );
					},
				),
			),
			'token_source_destroy' => array(
				'path' => '/token/source/(?P<source>\S+)',
				'args' => array(
					'methods'             => 'DELETE',
					'callback'            => array( $this->controllers['token_source'], 'destroy' ),
					'permission_callback' => function () {
						return current_user_can( 'manage_options' );
					},
				),
			),
			'user_credit_balance_index' => array(
				'path' => '/user/(?P<id>[\S]+)/credit/balance',
				'args' => array(
					'methods'             => 'GET',
					'callback'            => array( $this->controllers['user'], 'credit_balance_index' ),
					'permission_callback' => function () {
						return current_user_can( 'manage_options' );
					},
				),
			),
			'user_token_balance_index' => array(
				'path' => '/user/(?P<id>[\S]+)/token/balance',
				'args' => array(
					'methods'             => 'GET',
					'callback'            => array( $this->controllers['user'], 'token_balance_index' ),
					'permission_callback' => function () {
						return current_user_can( 'manage_options' );
					},
				),
			),
			'user_token_address_index' => array(
				'path' => '/user/(?P<id>[\S]+)/token/address',
				'args' => array(
					'methods'             => 'GET',
					'callback'            => array( $this->controllers['user'], 'token_address_index' ),
					'permission_callback' => function () {
						return current_user_can( 'manage_options' );
					},
				),
			),
			'user_show' => array(
				'path' => '/user/(?P<id>[\S]+)',
				'args' => array(
					'methods'             => 'GET',
					'callback'            => array( $this->controllers['user'], 'show' ),
					'permission_callback' => function ( \WP_REST_Request $request ) {
						$id = $request->get_param( 'id' );
						if ( current_user_can( 'administrator' ) === false && $id != 'me' ) {
							return false;
						}
						return true;
					},
				),
			),
			'user_index' => array(
				'path' => '/user',
				'args' => array(
					'methods'             => 'GET',
					'callback'            => array( $this->controllers['user'], 'index' ),
					'permission_callback' => function () {
						return current_user_can( 'manage_options' );
					},
				),
			),
			'integration_settings_show' => array(
				'path' => "/settings/integration",
				'args' => array(
					'methods'             => 'GET',
					'callback'            => array( $this->controllers['settings'], 'show_integration' ),
					'permission_callback' => function () {
						return current_user_can( 'manage_options' );
					},
				),
			),
			'settings_show_oauth' => array(
				'path' => "/settings/oauth",
				'args' => array(
					'methods'             => 'GET',
					'callback'            => array( $this->controllers['settings'], 'show_oauth' ),
					'permission_callback' => function () {
						return current_user_can( 'manage_options' );
					},
				),
			),
			'settings_show_tca' => array(
				'path' => "/settings/tca",
				'args' => array(
					'methods'             => 'GET',
					'callback'            => array( $this->controllers['settings'], 'show_tca' ),
					'permission_callback' => function () {
						return current_user_can( 'manage_options' );
					},
				),
			),
			'settings_show_token_whitelist' => array(
				'path' => "/settings/token-whitelist",
				'args' => array(
					'methods'             => 'GET',
					'callback'            => array( $this->controllers['settings'], 'show_token_whitelist' ),
					'permission_callback' => function () {
						return current_user_can( 'manage_options' );
					},
				),
			),
			'settings_update_integration' => array(
				'path' => '/settings/integration',
				'args' => array(
					'methods'             => 'PUT',
					'callback'            => array( $this->controllers['settings'], 'update_integration' ),
					'permission_callback' => function () {
						return current_user_can( 'manage_options' );
					},
				),
			),
			'settings_update_oauth' => array(
				'path' => '/settings/oauth',
				'args' => array(
					'methods'             => 'PUT',
					'callback'            => array( $this->controllers['settings'], 'update_oauth' ),
					'permission_callback' => function () {
						return current_user_can( 'manage_options' );
					},
				),
			),
			'settings_update_tca' => array(
				'path' => '/settings/tca',
				'args' => array(
					'methods'             => 'PUT',
					'callback'            => array( $this->controllers['settings'], 'update_tca' ),
					'permission_callback' => function () {
						return current_user_can( 'manage_options' );
					},
				),
			),
			'settings_update_token_whitelist' => array(
				'path' => '/settings/token-whitelist',
				'args' => array(
					'methods'             => 'PUT',
					'callback'            => array( $this->controllers['settings'], 'update_token_whitelist' ),
					'permission_callback' => function () {
						return current_user_can( 'manage_options' );
					},
				),
			),
		);
		$routes = $this->process_routes( $routes );
		return $routes;
	}

	protected function process_routes( $routes ) {
		foreach ( $routes as &$route ) {
			$callback = $route['args']['callback'];
			$route['args']['callback'] = function( $request ) use ( $callback ) {
				$controller = $callback[0];
				$method = $callback[1];
				if ( method_exists( $controller, 'call' ) ) {
					return call_user_func( array( $controller, 'call' ), $request, $method );
				} else {
					return call_user_func( $callback, $request );
				}
			};
		}
		return $routes;
	}
}
