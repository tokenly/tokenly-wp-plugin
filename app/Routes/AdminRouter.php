<?php

namespace Tokenly\Wp\Routes;

use Tokenly\Wp\Interfaces\Routes\AdminRouterInterface;
use Tokenly\Wp\Interfaces\Services\AuthServiceInterface;
use Tokenly\Wp\Interfaces\Controllers\Web\Admin\DashboardControllerInterface;
use Tokenly\Wp\Interfaces\Controllers\Web\Admin\ConnectionControllerInterface;
use Tokenly\Wp\Interfaces\Controllers\Web\Admin\SettingsControllerInterface;
use Tokenly\Wp\Interfaces\Controllers\Web\Admin\Credit\BalanceControllerInterface as CreditBalanceControllerInterface;
use Tokenly\Wp\Interfaces\Controllers\Web\Admin\Credit\GroupControllerInterface as CreditGroupControllerInterface;
use Tokenly\Wp\Interfaces\Controllers\Web\Admin\Credit\TransactionControllerInterface as CreditTransactionControllerInterface;
use Tokenly\Wp\Interfaces\Controllers\Web\Admin\Token\BalanceControllerInterface as TokenBalanceControllerInterface;
use Tokenly\Wp\Interfaces\Controllers\Web\Admin\Token\VendorControllerInterface as TokenVendorControllerInterface;
use Tokenly\Wp\Interfaces\Controllers\Web\Admin\Token\PromiseControllerInterface as TokenPromiseControllerInterface;
use Tokenly\Wp\Interfaces\Controllers\Web\Admin\Token\SourceControllerInterface as TokenSourceControllerInterface;
use Tokenly\Wp\Interfaces\Controllers\Web\Admin\Token\WhitelistControllerInterface as TokenWhitelistControllerInterface;
use Tokenly\Wp\Interfaces\Models\IntegrationInterface;
use Tokenly\Wp\Interfaces\Models\CurrentUserInterface;
use Tokenly\Wp\Routes\Router;
use Twig\Environment;

/**
 * Manages routing for the WordPress admin pages
 * The responses from the controllers are routed back to the router. It is to render the views since
 * every response is the same (render dynamic view) and only the data is different.
 * All admin routes are rendered by client so there is no need for more than one template.
 */
class AdminRouter extends Router implements AdminRouterInterface {
	protected $routes = array();
	protected $redirects = array();
	protected $controllers = array();
	protected $auth_service;
	protected $integration;
	protected $current_user;
	protected $root_dir;
	protected $api_host;
	protected $namespace;
	protected $twig;
	protected $default_template = 'Dynamic.twig';

	public function __construct(
		string $root_dir,
		string $namespace,
		string $api_host,
		AuthServiceInterface $auth_service,
		ConnectionControllerInterface $connection_controller,
		CreditBalanceControllerInterface $credit_balance_controller,
		CreditGroupControllerInterface $credit_group_controller,
		CreditTransactionControllerInterface $credit_transaction_controller,
		CurrentUserInterface $current_user,
		DashboardControllerInterface $dashboard_controller,
		Environment $twig,
		IntegrationInterface $integration,
		SettingsControllerInterface $settings_controller,
		TokenBalanceControllerInterface $token_balance_controller,
		TokenPromiseControllerInterface $token_promise_controller,
		TokenSourceControllerInterface $token_source_controller,
		TokenWhitelistControllerInterface $token_whitelist_controller,
		TokenVendorControllerInterface $token_vendor_controller
	) {
		$this->root_dir = $root_dir;
		$this->api_host = $api_host;
		$this->namespace = $namespace;
		$this->integration = $integration;
		$this->current_user = $current_user;
		$this->auth_service = $auth_service;
		$this->controllers = array(
			'connection'          => $connection_controller,
			'credit-balance'      => $credit_balance_controller,
			'credit-transaction'  => $credit_transaction_controller,
			'credit-group'        => $credit_group_controller,
			'dashboard'           => $dashboard_controller,
			'settings'            => $settings_controller,
			'token-vendor'        => $token_vendor_controller,
			'token-whitelist'     => $token_whitelist_controller,
			'token-promise'       => $token_promise_controller,
			'token-source'        => $token_source_controller,
			'token-balance'       => $token_balance_controller,
		);
		$this->twig = $twig;
	}

	/**
	 * Hooks the router to WordPress
	 */
	public function register() {
		$this->integration->can_connect();
		$this->routes = $this->get_routes();
		add_action( 'admin_menu', array( $this, 'register_routes' ), 9 );
	}
	
	/**
	 * Specifies the routes which are accessible even if
	 * the integration is unable to connect
	 * @return string[]
	 */
	protected function get_offline_routes_integration() {
		return array(
			$this->namespace,
			'settings',
		);
	}
	
	/**
	 * Specifies the routes which are accessible even if
	 * the user is unable to connect
	 * @return string[]
	 */
	protected function get_offline_routes_user() {
		return array(
			'connection',
		);
	}
	
	protected function can_register( string $route ) {
		if ( $this->current_user->is_guest() === true ) {
			return false;
		}
		if ( $this->integration->can_connect() ) {
			if ( $this->current_user->can_connect() ) {
				return true;
			} else if ( in_array( $route, $this->get_offline_routes_user() ) ) {
				return true;
			}
		}
		if ( in_array( $route, $this->get_offline_routes_integration() ) ) {
			return true;
		}
		return false;
	}
	
	/**
	 * Gets the admin route definitions
	 * @return array
	 */
	protected function get_routes() {
		$namespace_title = ucfirst( $this->namespace );
		$routes = array(
			$this->namespace => array(
				'page_title' => $namespace_title,
				'menu_title' => $namespace_title,
				'menu_slug'  => $this->namespace,
				'callable'   => array( $this->controllers['dashboard'], 'show' ),
				'capability' => 'read',
				'icon_url'   => 'data:image/svg+xml;base64,' . base64_encode( file_get_contents( $this->root_dir . '/resources/images/tokenly_logo.svg' ) ),
				'position'   => 3,
				'subroutes'   => array(
					'connection' => array(
						'page_title' => 'Connection Status',
						'menu_title' => 'Connection',
						'menu_slug'  => 'connection',
						'callable'   => array( $this->controllers['connection'], 'show' ),
						'capability' => 'read',
					),
					'credit-balance-index' => array(
						'page_title'  => 'Credit balance details',
						'menu_title'  => 'Credit balance details',
						'menu_slug'   => 'credit-balance-index',
						'callable'    => array( $this->controllers['credit-balance'], 'index' ),
						'capability'  => 'manage_options',
					),
					'credit-group-index' => array(
						'page_title'  => 'Credit group list',
						'menu_title'  => 'Credit group list',
						'menu_slug'   => 'credit-group-index',
						'callable'    => array( $this->controllers['credit-group'], 'index' ),
						'capability'  => 'manage_options',
					),
					'credit-group-store' => array(
						'parent_slug' => null,
						'page_title'  => 'Credit group creator',
						'menu_title'  => 'Credit group creator',
						'menu_slug'   => 'credit-group-store',
						'callable'    => array( $this->controllers['credit-group'], 'store' ),
						'capability'  => 'manage_options',
					),
					'credit-group-edit' => array(
						'parent_slug' => null,
						'page_title'  => 'Credit group editor',
						'menu_title'  => 'Credit group editor',
						'menu_slug'   => 'credit-group-edit',
						'callable'    => array( $this->controllers['credit-group'], 'edit' ),
						'capability'  => 'manage_options',
					),
					'credit-group-show' => array(
						'parent_slug' => null,
						'page_title'  => 'Credit group details',
						'menu_title'  => 'Credit group details',
						'menu_slug'   => 'credit-group-show',
						'callable'    => array( $this->controllers['credit-group'], 'show' ),
						'capability'  => 'manage_options',
					),
					'credit-transaction-index' => array(
						'parent_slug' => null,
						'page_title'  => 'Credit transaction list',
						'menu_title'  => 'Credit transaction list',
						'menu_slug'   => 'credit-transaction-index',
						'callable'    => array( $this->controllers['credit-transaction'], 'index' ),
						'capability'  => 'manage_options',
					),
					'credit-transaction-store' => array(
						'parent_slug' => null,
						'page_title'  => 'Credit transaction creator',
						'menu_title'  => 'Credit transaction creator',
						'menu_slug'   => 'credit-transaction-store',
						'callable'    => array( $this->controllers['credit-transaction'], 'store' ),
						'capability'  => 'manage_options',
					),
					'dashboard' => array(
						'page_title' => 'Dashboard',
						'menu_title' => 'Dashboard',
						'menu_slug'  => 'dashboard',
						'capability' => 'use_tokenpass',
					),
					'settings' => array(
						'page_title' => 'Settings',
						'menu_title' => 'Settings',
						'menu_slug'  => 'settings',
						'callable'   => array( $this->controllers['settings'], 'show' ),
						'capability' => 'manage_options',
					),
					'token-vendor' => array(
						'page_title' => 'Token vendor',
						'menu_title' => 'Vendor',
						'menu_slug'  => 'token-vendor',
						'callable'   => array( $this->controllers['token-vendor'], 'show' ),
						'capability' => 'manage_options',
					),
					'token-balance-index' => array(
						'parent_slug' => null,
						'page_title'  => 'Token balance details',
						'menu_title'  => 'Token balance details',
						'menu_slug'   => 'token-balance-index',
						'callable'    => array( $this->controllers['token-balance'], 'index' ),
						'capability'  => 'manage_options',
					),
					'token-promise-show' => array(
						'parent_slug' => null,
						'page_title'  => 'Token promise details',
						'menu_title'  => 'Token promise details',
						'menu_slug'   => 'token-promise-show',
						'callable'    => array( $this->controllers['token-promise'], 'show' ),
						'capability'  => 'manage_options',
					),
					'token-promise-store' => array(
						'parent_slug' => null,
						'page_title'  => 'Create token promise',
						'menu_title'  => 'Create promise',
						'menu_slug'   => 'token-promise-store',
						'callable'    => array( $this->controllers['token-promise'], 'store' ),
						'capability'  => 'manage_options',
					),
					'token-promise-edit' => array(
						'parent_slug' => null,
						'page_title'  => 'Token promise editor',
						'menu_title'  => 'Token promise editor',
						'menu_slug'   => 'token-promise-edit',
						'callable'    => array( $this->controllers['token-promise'], 'edit' ),
						'capability'  => 'manage_options',
					),
					'token-source-index' => array(
						'parent_slug' => null,
						'page_title'  => 'Token source list',
						'menu_title'  => 'Token source list',
						'menu_slug'   => 'token-source-index',
						'callable'    => array( $this->controllers['token-source'], 'index' ),
						'capability'  => 'manage_options',
					),
					'token-source-show' => array(
						'parent_slug' => null,
						'page_title'  => 'Token source details',
						'menu_title'  => 'Token source details',
						'menu_slug'   => 'token-source-show',
						'callable'    => array( $this->controllers['token-source'], 'show' ),
						'capability'  => 'manage_options',
					),
					'token-source-store' => array(
						'parent_slug' => null,
						'page_title'  => 'Token source creator',
						'menu_title'  => 'Token source creator',
						'menu_slug'   => 'token-source-store',
						'callable'    => array( $this->controllers['token-source'], 'store' ),
						'capability'  => 'manage_options',
					),
					'token-source-edit' => array(
						'parent_slug' => null,
						'page_title'  => 'Token source editor',
						'menu_title'  => 'Token source editor',
						'menu_slug'   => 'token-source-edit',
						'callable'    => array( $this->controllers['token-source'], 'edit' ),
						'capability'  => 'manage_options',
					),
					'token-whitelist' => array(
						'page_title' => 'Token whitelist editor',
						'menu_title' => 'Whitelist',
						'menu_slug'  => 'token-whitelist-edit',
						'callable'   => array( $this->controllers['token-whitelist'], 'edit' ),
						'capability' => 'manage_options',
					),
					'inventory' => array(
						'page_title' => 'Inventory',
						'menu_title' => 'Inventory',
						'menu_slug'  => 'inventory',
						'capability' => 'use_tokenpass',
					),
				),
			),
		);
		$routes = $this->process_routes( $routes );
		return $routes;
	}

	/**
	 * Transforms the submenu slugs to contain parent menu slug
	 * @param array $routes Admin routes
	 * @return array
	 */
	protected function process_routes( array $routes ) {
		foreach ( $routes as &$route ) {
			$route = $this->process_route( $route );
			$route = $this->process_subroutes( $route );
		}
		return $routes;
	}

	/**
	 * Prepares a group of subroutes before rendering
	 * @param array $route
	 * @return array $route
	 */
	protected function process_subroutes( $route ) {
		if ( !isset( $route['subroutes'] ) ) {
			return;
		}
		$subroutes = $route['subroutes'];
		foreach ( $subroutes as &$subroute ) {
			$subroute = $this->process_subroute( $route, $subroute );
		}
		$route['subroutes'] = $subroutes;
		return $route;
	}

	/**
	 * Prepares a single subroute before rendering
	 * @param array $route Parent route data
	 * @param array $subroute Subroute data
	 * @return array
	 */
	protected function process_subroute( $route, $subroute ) {
		$subroute = $this->process_route( $subroute );
		$menu_slug = $this->get_subroute_slug( $route, $subroute );
		$subroute['menu_slug'] = $menu_slug;
		return $subroute;
	}

	/**
	 * Prepare a single route before rendering
	 * @param array $route Route data
	 * @return array
	 */
	protected function process_route( $route ) {
		if ( isset( $route['callable'] ) ) {
			$callable = $route['callable'];
			$route['callable'] = function() use ( $callable ) {
				$this->render_route( $callable );
			};
		}
		return $route;
	}

	/**
	 * Prefixes the child route slug with the parent's slug
	 * @param array $route Parent route
	 * @param array $subroute Child route
	 * @return string
	 */
	protected function get_subroute_slug( $route, $subroute ) {
		if ( !isset( $route['menu_slug'] ) || !isset( $subroute['menu_slug'] ) ) {
			return false;
		}
		$route_slug = $route['menu_slug'];
		$subroute_slug = $subroute['menu_slug'];
		return implode( '-', array( $route_slug, $subroute_slug ) );
	}

	/**
	 * Registers admin route
	 * @param array $route Route data
	 * @return void
	 */
	public function register_route( string $key, array $route ) {
		if ( $this->can_register( $key ) === true ) {
			add_menu_page(
				$route['page_title'] ?? null,
				$route['menu_title'] ?? null,
				$route['capability'] ?? null,
				$route['menu_slug'] ?? null,
				$route['callable'] ?? null,
				$route['icon_url'] ?? null,
				$route['position'] ?? null,
			);
		}
		if ( isset( $route['subroutes'] ) ) {
			$subroutes = $route['subroutes'] ?? null;
			foreach ( $subroutes as $key => $subroute ) {
				$this->register_subroute( $key, $subroute, $route );
			}
		}
	}

	/**
	 * Registers admin subroute
	 * @param array $subroute Subroute data
	 * @param array $route Parent route data
	 * @return void
	 */
	protected function register_subroute( string $key, array $subroute, array $route ) {
		if ( array_key_exists( 'parent_slug', $subroute ) === false ) {
			$subroute['parent_slug'] = $route['menu_slug'] ?? null;
		}
		if ( $this->can_register( $key ) === false ) {
			return false;
		}
		add_submenu_page(
			$subroute['parent_slug'] ?? null,
			$subroute['page_title'] ?? null,
			$subroute['menu_title'] ?? null,
			$subroute['capability'] ?? null,
			$subroute['menu_slug'] ?? null,
			$subroute['callable'] ?? null,
			$subroute['icon_url'] ?? null,
			$subroute['position'] ?? null,
		);
	}
}
