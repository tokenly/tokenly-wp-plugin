<?php

namespace Tokenly\Wp\Routes;

use Tokenly\Wp\Routes\Router;
use Tokenly\Wp\Interfaces\Routes\ApiRouterInterface;
use Tokenly\Wp\Interfaces\Controllers\Api\AuthControllerInterface;
use Tokenly\Wp\Interfaces\Controllers\Api\UserControllerInterface;
use Tokenly\Wp\Interfaces\Controllers\Api\Credit\GroupControllerInterface as CreditGroupControllerInterface;
use Tokenly\Wp\Interfaces\Controllers\Api\Credit\TransactionControllerInterface as CreditTransactionControllerInterface;
use Tokenly\Wp\Interfaces\Controllers\Api\Token\PromiseControllerInterface as TokenPromiseControllerInterface;
use Tokenly\Wp\Interfaces\Controllers\Api\Token\SourceControllerInterface as TokenTokenSourceControllerInterface;
use Tokenly\Wp\Interfaces\Controllers\Api\Settings\IntegrationControllerInterface as IntegrationSettingsControllerInterface;
use Tokenly\Wp\Interfaces\Controllers\Api\Settings\TcaControllerInterface as TcaSettingsControllerInterface;
use Tokenly\Wp\Interfaces\Controllers\Api\Settings\OauthControllerInterface as OauthSettingsControllerInterface;
use Tokenly\Wp\Interfaces\Controllers\Api\Settings\Token\WhitelistControllerInterface as TokenWhitelistSettingsControllerInterface;

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
		TokenPromiseControllerInterface $token_promise_controller,
		TokenSourceControllerInterface $token_source_controller,
		UserControllerInterface $user_controller,
		IntegrationSettingsControllerInterface $integration_settings_controller,
		TcaSettingsControllerInterface $tca_settings_controller,
		OauthSettingsControllerInterface $oauth_settings_controller,
		TokenWhitelistSettingsControllerInterface $token_whitelist_settings_controller,
		string $namespace
	) {
		$this->namespace = $namespace;
		$this->api_namespace = "{$this->namespace}/v1";
		$this->controllers = array(
			'auth'                     => $auth_controller,
			'credit-group'             => $credit_group_controller,
			'credit-transaction'       => $credit_transaction_controller,
			'token-promise'            => $token_promise_controller,
			'token-source'             => $token_source_controller,
			'user'                     => $user_controller,
			'integration-settings'     => $integration_settings_controller,
			'tca-settings'             => $tca_settings_controller,
			'oauth-settings'           => $oauth_settings_controller,
			'token-whitelist-settings' => $token_whitelist_settings_controller,
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
			'token-promise-index' => array(
				'path' => '/token/promise',
				'args' => array(
					'methods'             => 'GET',
					'callback'            => array( $this->controllers['token-promise'], 'index' ),
					'permission_callback' => function () {
						return current_user_can( 'manage_options' );
					},
				),
			),
			'token-promise-store' => array(
				'path' => '/token/promise',
				'args' => array(
					'methods'             => 'POST',
					'callback'            => array( $this->controllers['token-promise'], 'store' ),
					'permission_callback' => function () {
						return current_user_can( 'manage_options' );
					},
				),
			),
			'token-promise-update' => array(
				'path' => '/token/promise/(?P<promise>[\d]+)',
				'args' => array(
					'methods'             => 'PUT',
					'callback'            => array( $this->controllers['token-promise'], 'update' ),
					'permission_callback' => function () {
						return current_user_can( 'manage_options' );
					},
				),
			),
			'token-promise-destroy' => array(
				'path' => '/token/promise/(?P<promise>[\d]+)',
				'args' => array(
					'methods'             => 'DELETE',
					'callback'            => array( $this->controllers['token-promise'], 'destroy' ),
					'permission_callback' => function () {
						return current_user_can( 'manage_options' );
					},
				),
			),
			'token-source-index' => array(
				'path' => '/token/source',
				'args' => array(
					'methods'             => 'GET',
					'callback'            => array( $this->controllers['token-source'], 'index' ),
					'permission_callback' => function () {
						return current_user_can( 'manage_options' );
					},
				),
			),
			'token-source-store' => array(
				'path' => '/token/source',
				'args' => array(
					'methods'             => 'POST',
					'callback'            => array( $this->controllers['token-source'], 'store' ),
					'permission_callback' => function () {
						return current_user_can( 'manage_options' );
					},
				),
			),
			'token-source-update' => array(
				'path' => '/token/source/(?P<address>[a-zA-Z0-9-]+)',
				'args' => array(
					'methods'             => 'PUT',
					'callback'            => array( $this->controllers['token-source'], 'update' ),
					'permission_callback' => function () {
						return current_user_can( 'manage_options' );
					},
				),
			),
			'token-source-destroy' => array(
				'path' => '/token/source/(?P<address>[a-zA-Z0-9-]+)',
				'args' => array(
					'methods'             => 'DELETE',
					'callback'            => array( $this->controllers['token-source'], 'destroy' ),
					'permission_callback' => function () {
						return current_user_can( 'manage_options' );
					},
				),
			),
			'credit-group-index' => array(
				'path' => '/credit/group',
				'args' => array(
					'methods'             => 'GET',
					'callback'            => array( $this->controllers['credit-group'], 'index' ),
					'permission_callback' => function () {
						return current_user_can( 'manage_options' );
					},
				),
			),
			'credit-group-store' => array(
				'path' => '/credit/group',
				'args' => array(
					'methods'             => 'POST',
					'callback'            => array( $this->controllers['credit-group'], 'store' ),
					'permission_callback' => function () {
						return current_user_can( 'manage_options' );
					},
				),
			),
			'credit-group-update' => array(
				'path' => '/credit/group',
				'args' => array(
					'methods'             => 'PUT',
					'callback'            => array( $this->controllers['credit-group'], 'update' ),
					'permission_callback' => function () {
						return current_user_can( 'manage_options' );
					},
				),
			),
			'credit-transaction-index' => array(
				'path' => '/credit/transaction',
				'args' => array(
					'methods'             => 'GET',
					'callback'            => array( $this->controllers['credit-transaction'], 'index' ),
					'permission_callback' => function () {
						return current_user_can( 'manage_options' );
					},
				),
			),
			'credit-transaction-store' => array(
				'path' => '/credit/transaction',
				'args' => array(
					'methods'             => 'POST',
					'callback'            => array( $this->controllers['credit-transaction'], 'store' ),
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
		$routes = array_merge( $routes, $this->get_settings_routes() );
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
			'token-whitelist',
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
				"{$section}-settings-show" => array(
					'path' => "/settings/{$section}",
					'args' => array(
						'methods'             => 'GET',
						'callback'            => array( $this->controllers["{$section}-settings"], 'show' ),
						'permission_callback' => function () {
							return current_user_can( 'manage_options' );
						},
					),
				),
				"{$section}-settings-update" => array(
					'path' => "/settings/{$section}",
					'args' => array(
						'methods'             => 'PUT',
						'callback'            => array( $this->controllers["{$section}-settings"], 'update' ),
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
