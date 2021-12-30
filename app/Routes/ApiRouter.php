<?php

namespace Tokenly\Wp\Routes;

use Tokenly\Wp\Routes\Router;
use Tokenly\Wp\Interfaces\Routes\ApiRouterInterface;
use Tokenly\Wp\Interfaces\Controllers\Api\AuthControllerInterface;
use Tokenly\Wp\Interfaces\Controllers\Api\UserControllerInterface;
use Tokenly\Wp\Interfaces\Controllers\Api\Credit\GroupControllerInterface as CreditGroupControllerInterface;
use Tokenly\Wp\Interfaces\Controllers\Api\Credit\TransactionControllerInterface as CreditTransactionControllerInterface;
use Tokenly\Wp\Interfaces\Controllers\Api\Token\AddressControllerInterface as TokenAddressControllerInterface;
use Tokenly\Wp\Interfaces\Controllers\Api\Token\BalanceControllerInterface as TokenBalanceControllerInterface;
use Tokenly\Wp\Interfaces\Controllers\Api\Token\PromiseControllerInterface as TokenPromiseControllerInterface;
use Tokenly\Wp\Interfaces\Controllers\Api\Token\SourceControllerInterface as TokenSourceControllerInterface;
use Tokenly\Wp\Interfaces\Controllers\Api\Settings\IntegrationControllerInterface as IntegrationSettingsControllerInterface;
use Tokenly\Wp\Interfaces\Controllers\Api\Settings\TcaControllerInterface as TcaSettingsControllerInterface;
use Tokenly\Wp\Interfaces\Controllers\Api\Settings\OauthControllerInterface as OauthSettingsControllerInterface;
use Tokenly\Wp\Interfaces\Controllers\Api\Settings\WhitelistControllerInterface as WhitelistSettingsControllerInterface;

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
		TokenBalanceControllerInterface $token_balance_controller,
		TokenPromiseControllerInterface $token_promise_controller,
		TokenSourceControllerInterface $token_source_controller,
		UserControllerInterface $user_controller,
		IntegrationSettingsControllerInterface $integration_settings_controller,
		TcaSettingsControllerInterface $tca_settings_controller,
		OauthSettingsControllerInterface $oauth_settings_controller,
		WhitelistSettingsControllerInterface $whitelist_settings_controller,
		string $namespace
	) {
		$this->namespace = $namespace;
		$this->api_namespace = "{$this->namespace}/v1";
		$this->controllers = array(
			'auth'                     => $auth_controller,
			'credit_group'             => $credit_group_controller,
			'credit_transaction'       => $credit_transaction_controller,
			'token_address'            => $token_address_controller,
			'token_balance'            => $token_balance_controller,
			'token_promise'            => $token_promise_controller,
			'token_source'             => $token_source_controller,
			'user'                     => $user_controller,
			'integration_settings'     => $integration_settings_controller,
			'tca_settings'             => $tca_settings_controller,
			'oauth_settings'           => $oauth_settings_controller,
			'whitelist_settings'       => $whitelist_settings_controller,
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
			'token_balance_index' => array(
				'path' => '/token/balance',
				'args' => array(
					'methods'             => 'GET',
					'callback'            => array( $this->controllers['token_balance'], 'index' ),
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
			'user_show' => array(
				'path' => '/user/(?P<id>\S+)',
				'args' => array(
					'methods'             => 'GET',
					'callback'            => array( $this->controllers['user'], 'show' ),
					'permission_callback' => function () {
						return current_user_can( 'manage_options' );
					},
				),
			),
		);
		$routes = array_merge( $routes, $this->get_settings_routes() );
		$routes = $this->process_routes( $routes );
		return $routes;
	}

	protected function process_routes( $routes ) {
		foreach ( $routes as &$route ) {
			$callback = $route['args']['callback'];
			$route['args']['callback'] = function( $request ) use ( $callback ) {
				$controller = $callback[0];
				$method = $callback[1];
				switch ( $method ) {
					case 'index':
					case 'show':
					case 'update':
					case 'destroy':
						if ( method_exists( $controller, 'bind' ) ) {
							$model = call_user_func( array( $controller, 'bind' ), $request, $method );
							return call_user_func( $callback, $model, $request );
						} else {
							return call_user_func( $callback, $request );
						}
						break;
					default:
						return call_user_func( $callback, $request );
				}
			};
		}
		return $routes;
	}

	/**
	 * Retrieves the settings categories
	 * @return array
	 */
	protected function get_settings_sections() {
		return array(
			'tca',
			'integration',
			'oauth',
			'whitelist',
		);
	}

	/**
	 * Get settings route definitions
	 * @return array
	 */
	protected function get_settings_routes() {
		$sections = $this->get_settings_sections();
		$routes = array();
		foreach ( $sections as $section ) {
			$routes = array_merge( $routes, array(
				"{$section}_settings_show" => array(
					'path' => "/settings/{$section}",
					'args' => array(
						'methods'             => 'GET',
						'callback'            => array( $this->controllers["{$section}_settings"], 'show' ),
						'permission_callback' => function () {
							return current_user_can( 'manage_options' );
						},
					),
				),
				"{$section}_settings_update" => array(
					'path' => "/settings/{$section}",
					'args' => array(
						'methods'             => 'PUT',
						'callback'            => array( $this->controllers["{$section}_settings"], 'update' ),
						'permission_callback' => function () {
							return current_user_can( 'manage_options' );
						},
					),
				),
			) );
		}
		return $routes;
	}
}
