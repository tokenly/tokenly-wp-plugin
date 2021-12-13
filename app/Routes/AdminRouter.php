<?php

namespace Tokenly\Wp\Routes;

use Tokenly\Wp\Interfaces\Routes\AdminRouterInterface;
use Tokenly\Wp\Interfaces\Services\AuthServiceInterface;
use Tokenly\Wp\Interfaces\Controllers\Web\Admin\BalancesControllerInterface;
use Tokenly\Wp\Interfaces\Controllers\Web\Admin\CreditGroupControllerInterface;
use Tokenly\Wp\Interfaces\Controllers\Web\Admin\CreditTransactionControllerInterface;
use Tokenly\Wp\Interfaces\Controllers\Web\Admin\DashboardControllerInterface;
use Tokenly\Wp\Interfaces\Controllers\Web\Admin\VendorControllerInterface;
use Tokenly\Wp\Interfaces\Controllers\Web\Admin\WhitelistControllerInterface;
use Tokenly\Wp\Interfaces\Controllers\Web\Admin\ConnectionControllerInterface;
use Tokenly\Wp\Interfaces\Controllers\Web\Admin\SettingsControllerInterface;
use Tokenly\Wp\Interfaces\Controllers\Web\Admin\PromiseControllerInterface;
use Tokenly\Wp\Interfaces\Controllers\Web\Admin\SourceControllerInterface;
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
		BalancesControllerInterface $balances_controller,
		DashboardControllerInterface $dashboard_controller,
		CreditGroupControllerInterface $credit_group_controller,
		CreditTransactionControllerInterface $credit_transaction_controller,
		VendorControllerInterface $vendor_controller,
		WhitelistControllerInterface $whitelist_controller,
		ConnectionControllerInterface $connection_controller,
		SettingsControllerInterface $settings_controller,
		PromiseControllerInterface $promise_controller,
		SourceControllerInterface $source_controller,
		IntegrationInterface $integration,
		CurrentUserInterface $current_user,
		Environment $twig
	) {
		$this->namespace = $namespace;
		$this->api_host = $api_host;
		$this->root_dir = $root_dir;
		$this->integration = $integration;
		$this->current_user = $current_user;
		$this->auth_service = $auth_service;
		$this->controllers = array(
			'dashboard'           => $dashboard_controller,
			'credit-transaction'  => $credit_transaction_controller,
			'credit-group'        => $credit_group_controller,
			'vendor'              => $vendor_controller,
			'whitelist'           => $whitelist_controller,
			'connection'          => $connection_controller,
			'settings'            => $settings_controller,
			'promise'             => $promise_controller,
			'source'              => $source_controller,
			'balances'            => $balances_controller,
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
		add_action( 'admin_print_scripts', array( $this, 'add_redirects' ) );
	}

	/**
	 * Redirects some admin menu pages
	 * @return void
	 */
	public function add_redirects() {
		$id = get_current_user_id();
		echo "	
			<script type='text/javascript'>
				window.tokenpassRedirects = [
					{
						from: '{$this->namespace}-inventory',
						to: '/{$this->namespace}/user/me',
					},
					{
						from: '{$this->namespace}-dashboard',
						to: '{$this->api_host}/dashboard',
					},
				];
			</script>
		"; 
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
					'dashboard' => array(
						'page_title' => 'Dashboard',
						'menu_title' => 'Dashboard',
						'menu_slug'  => 'dashboard',
						'capability' => 'use_tokenpass',
					),
					'inventory' => array(
						'page_title' => 'Inventory',
						'menu_title' => 'Inventory',
						'menu_slug'  => 'inventory',
						'capability' => 'use_tokenpass',
					),
					'connection' => array(
						'page_title' => 'Connection Status',
						'menu_title' => 'Connection',
						'menu_slug'  => 'connection',
						'callable'   => array( $this->controllers['connection'], 'show' ),
						'capability' => 'read',
					),
					'vendor' => array(
						'page_title' => 'Tokenly Vendor',
						'menu_title' => 'Vendor',
						'menu_slug'  => 'vendor',
						'callable'   => array( $this->controllers['vendor'], 'show' ),
						'capability' => 'manage_options',
					),
					'balances-show' => array(
						'parent_slug' => null,
						'page_title'  => 'Show source balances',
						'menu_title'  => 'Source balances',
						'menu_slug'   => 'balances-show',
						'callable'    => array( $this->controllers['balances'], 'show' ),
						'capability'  => 'manage_options',
					),
					'promise-show' => array(
						'parent_slug' => null,
						'page_title'  => 'View token promise',
						'menu_title'  => 'View promise',
						'menu_slug'   => 'promise-show',
						'callable'    => array( $this->controllers['promise'], 'show' ),
						'capability'  => 'manage_options',
					),
					'promise-store' => array(
						'parent_slug' => null,
						'page_title'  => 'Create token promise',
						'menu_title'  => 'Create promise',
						'menu_slug'   => 'promise-store',
						'callable'    => array( $this->controllers['promise'], 'store' ),
						'capability'  => 'manage_options',
					),
					'promise-edit' => array(
						'parent_slug' => null,
						'page_title'  => 'Manage token promise',
						'menu_title'  => 'Manage promise',
						'menu_slug'   => 'promise-edit',
						'callable'    => array( $this->controllers['promise'], 'edit' ),
						'capability'  => 'manage_options',
					),
					'credit-group-index' => array(
						'page_title'  => 'App Credits',
						'menu_title'  => 'App Credits',
						'menu_slug'   => 'credit-group-index',
						'callable'    => array( $this->controllers['credit-group'], 'index' ),
						'capability'  => 'manage_options',
					),
					'credit-group-store' => array(
						'parent_slug' => null,
						'page_title'  => 'Create credit group',
						'menu_title'  => 'Create credit group',
						'menu_slug'   => 'credit-group-store',
						'callable'    => array( $this->controllers['credit-group'], 'store' ),
						'capability'  => 'manage_options',
					),
					'credit-group-edit' => array(
						'parent_slug' => null,
						'page_title'  => 'Manage credit group',
						'menu_title'  => 'Manage credit group',
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
						'page_title'  => 'App Credits list',
						'menu_title'  => 'App Credits list',
						'menu_slug'   => 'credit-transaction-index',
						'callable'    => array( $this->controllers['credit-transaction'], 'index' ),
						'capability'  => 'manage_options',
					),
					'credit-transaction-store' => array(
						'parent_slug' => null,
						'page_title'  => 'App Credits create transaction',
						'menu_title'  => 'App Credits create transaction',
						'menu_slug'   => 'credit-transaction-store',
						'callable'    => array( $this->controllers['credit-transaction'], 'store' ),
						'capability'  => 'manage_options',
					),
					'source-index' => array(
						'parent_slug' => null,
						'page_title'  => 'Manage source addresses',
						'menu_title'  => 'Source',
						'menu_slug'   => 'source-index',
						'callable'    => array( $this->controllers['source'], 'index' ),
						'capability'  => 'manage_options',
					),
					'source-show' => array(
						'parent_slug' => null,
						'page_title'  => 'Show source address details',
						'menu_title'  => 'Source details',
						'menu_slug'   => 'source-show',
						'callable'    => array( $this->controllers['source'], 'show' ),
						'capability'  => 'manage_options',
					),
					'source-store' => array(
						'parent_slug' => null,
						'page_title'  => 'Register source address',
						'menu_title'  => 'Register source',
						'menu_slug'   => 'source-store',
						'callable'    => array( $this->controllers['source'], 'store' ),
						'capability'  => 'manage_options',
					),
					'source-edit' => array(
						'parent_slug' => null,
						'page_title'  => 'Manage source address',
						'menu_title'  => 'Manage source',
						'menu_slug'   => 'source-edit',
						'callable'    => array( $this->controllers['source'], 'edit' ),
						'capability'  => 'manage_options',
					),
					'whitelist' => array(
						'page_title' => 'Gallery Token Whitelist',
						'menu_title' => 'Whitelist',
						'menu_slug'  => 'whitelist',
						'callable'   => array( $this->controllers['whitelist'], 'show' ),
						'capability' => 'manage_options',
					),
					'settings' => array(
						'page_title' => 'Settings',
						'menu_title' => 'Settings',
						'menu_slug'  => 'settings',
						'callable'   => array( $this->controllers['settings'], 'show' ),
						'capability' => 'manage_options',
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
