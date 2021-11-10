<?php

namespace Tokenly\Wp\Routes;

use Tokenly\Wp\Interfaces\Routes\AdminRouterInterface;
use Tokenly\Wp\Interfaces\Services\AuthServiceInterface;
use Tokenly\Wp\Interfaces\Controllers\Web\Admin\DashboardControllerInterface;
use Tokenly\Wp\Interfaces\Controllers\Web\Admin\VendorControllerInterface;
use Tokenly\Wp\Interfaces\Controllers\Web\Admin\WhitelistControllerInterface;
use Tokenly\Wp\Interfaces\Controllers\Web\Admin\ConnectionControllerInterface;
use Tokenly\Wp\Interfaces\Controllers\Web\Admin\SettingsControllerInterface;
use Tokenly\Wp\Interfaces\Controllers\Web\Admin\PromiseControllerInterface;
use Tokenly\Wp\Interfaces\Controllers\Web\Admin\SourceControllerInterface;

/**
 * Manages routing for the WordPress admin pages
 */
class AdminRouter implements AdminRouterInterface {
	protected $routes;
	protected $redirects = array();

	public function __construct(
		AuthServiceInterface $auth_service,
		DashboardControllerInterface $dashboard_controller,
		VendorControllerInterface $vendor_controller,
		WhitelistControllerInterface $whitelist_controller,
		ConnectionControllerInterface $connection_controller,
		SettingsControllerInterface $settings_controller,
		PromiseControllerInterface $promise_controller,
		SourceControllerInterface $source_controller
	) {
		$this->auth_service =$auth_service;
		$this->controllers = array(
			'dashboard'  => $dashboard_controller,
			'vendor'     => $vendor_controller,
			'whitelist'  => $whitelist_controller,
			'connection' => $connection_controller,
			'settings'   => $settings_controller,
			'promise'    => $promise_controller,
			'source'     => $source_controller,
		);
	}

	/**
	 * Hooks the router to WordPress
	 */
	public function register() {
		$this->routes = $this->get_routes();
		add_action( 'admin_menu', array( $this, 'register_routes' ), 9 );
		add_action( 'admin_print_scripts', array( $this, 'add_redirects' ) );
	}

	/**
	 * Registers the admin routes
	 * @return void
	 */
	public function register_routes() {
		foreach ( $this->routes as $route ) {
			$this->register_route( $route );
		}
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
						from: 'tokenpass-inventory',
						to: '/tokenpass-user/me',
					},
					{
						from: 'tokenpass-dashboard',
						to: 'https://tokenpass.tokenly.com/dashboard',
					},
				];
			</script>
		"; 
	}
	
	/**
	 * Checks if the current user has enough capabilites
	 * to view the Tokenpass inventory
	 * @return boolean
	 */
	protected function can_view_inventory() {
		if ( current_user_can( 'read' ) === true && $this->auth_service->is_connected() === true ) {
			return true;
		} else {
			return false;
		}
	}

	/**
	 * Gets the admin route definitions
	 * @return array
	 */
	protected function get_routes() {
		$routes = array(
			'tokenpass' => array(
				'args'    => array(
					'page_title' => 'Tokenpass',
					'menu_title' => 'Tokenpass',
					'menu_slug'  => 'tokenpass',
					'callable'   => array( $this->controllers['dashboard'], 'show' ),
					'capability' => 'read',
					'icon_url'   => 'data:image/svg+xml;base64,' . base64_encode( file_get_contents( plugin_dir_url( __FILE__ ) . '../../resources/images/tokenly_logo.svg' ) ),
					'position'   => 3,
				),
				'subroutes'   => array(
					'dashboard' => array(
						'args'      => array(
							'page_title' => 'Dashboard',
							'menu_title' => 'Dashboard',
							'menu_slug'  => 'dashboard',
							'capability' => 'use_tokenpass',
						),
					),
					'inventory' => array(
						'args'      => array(
							'page_title' => 'Inventory',
							'menu_title' => 'Inventory',
							'menu_slug'  => 'inventory',
							'capability' => 'use_tokenpass',
						),
					),
					'connection' => array(
						'args'      => array(
							'page_title' => 'Connection Status',
							'menu_title' => 'Connection',
							'menu_slug'  => 'connection',
							'callable'   => array( $this->controllers['connection'], 'show' ),
							'capability' => 'read',
						),
					),
					'vendor' => array(
						'args'      => array(
							'page_title' => 'Tokenly Vendor',
							'menu_title' => 'Vendor',
							'menu_slug'  => 'vendor',
							'callable'   => array( $this->controllers['vendor'], 'show' ),
							'capability' => 'manage_options',
						),
					),
					'promise-store' => array(
						'args'      => array(
							'parent_slug' => null,
							'page_title'  => 'Create token promise',
							'menu_title'  => 'Create promise',
							'menu_slug'   => 'promise-store',
							'callable'    => array( $this->controllers['promise'], 'store' ),
							'capability'  => 'manage_options',
						),
					),
					'promise-edit' => array(
						'args'      => array(
							'parent_slug' => null,
							'page_title'  => 'Manage token promise',
							'menu_title'  => 'Manage promise',
							'menu_slug'   => 'promise-edit',
							'callable'    => array( $this->controllers['promise'], 'edit' ),
							'capability'  => 'manage_options',
						),
					),
					'source-index' => array(
						'args'      => array(
							'parent_slug' => null,
							'page_title'  => 'Manage source addresses',
							'menu_title'  => 'Source',
							'menu_slug'   => 'source-index',
							'callable'    => array( $this->controllers['source'], 'index' ),
							'capability'  => 'manage_options',
						),
					),
					'source-store' => array(
						'args'      => array(
							'parent_slug' => null,
							'page_title'  => 'Register source address',
							'menu_title'  => 'Register source',
							'menu_slug'   => 'source-store',
							'callable'    => array( $this->controllers['source'], 'store' ),
							'capability'  => 'manage_options',
						),
					),
					'source-edit' => array(
						'args'      => array(
							'parent_slug' => null,
							'page_title'  => 'Manage source address',
							'menu_title'  => 'Manage source',
							'menu_slug'   => 'source-edit',
							'callable'   => array( $this->controllers['source'], 'edit' ),
							'capability'  => 'manage_options',
						),
					),
					'whitelist' => array(
						'args'      => array(
							'page_title' => 'Gallery Token Whitelist',
							'menu_title' => 'Whitelist',
							'menu_slug'  => 'whitelist',
							'callable'   => array( $this->controllers['whitelist'], 'show' ),
							'capability' => 'manage_options',
						),
					),
					'settings' => array(
						'args'      => array(
							'page_title' => 'Settings',
							'menu_title' => 'Settings',
							'menu_slug'  => 'settings',
							'callable'   => array( $this->controllers['settings'], 'show' ),
							'capability' => 'manage_options',
						),
					),
				),
			),
		);
		$routes = $this->prepare_routes( $routes );
		return $routes;
	}

	/**
	 * Transforms the submenu slugs to contain parent menu slug
	 * @param array $routes Admin routes
	 * @return array
	 */
	protected function prepare_routes( $routes ) {
		$routes = array_map( function( $route ) {
			$subroutes = $route['subroutes'] ?? null;
			if ( $subroutes ) {
				$subroutes = array_map( function( $subroute ) use ( $route ) {
					$subroute_args = $subroute['args'] ?? null;
					if ( $subroute_args ) {
						$menu_slug = $this->get_subroute_slug( $route, $subroute );
						$subroute_args['menu_slug']= $menu_slug;
						$subroute['args'] = $subroute_args;
					}
					$subroute['args'] = $subroute_args;
					return $subroute;
				}, $subroutes );
				$route['subroutes'] = $subroutes;
			}
			return $route;
		}, $routes );
		return $routes;
	}

	/**
	 * Prefixes the child route slug with the parent's slug
	 * @param array $route Parent route
	 * @param array $subroute Child route
	 * @return string
	 */
	protected function get_subroute_slug( $route, $subroute ) {
		$route_args = $route['args'] ?? null;
		$subroute_args = $subroute['args'] ?? null;
		if ( $route_args && $subroute_args ) {
			$route_slug = $route_args['menu_slug'] ?? null;
			$subroute_slug = $subroute_args['menu_slug'] ?? null;
			if( $route_slug && $subroute_slug ) {
				return implode( '-', array( $route_slug, $subroute_slug ) );
			}
		}
	}

	/**
	 * Registers admin route
	 * @param array $route Route data
	 * @return void
	 */
	protected function register_route( $route ) {
		$args = $route['args'] ?? null;
		if ( $args ) {
			add_menu_page(
				$args['page_title'] ?? null,
				$args['menu_title'] ?? null,
				$args['capability'] ?? null,
				$args['menu_slug'] ?? null,
				$args['callable'] ?? null,
				$args['icon_url'] ?? null,
				$args['position'] ?? null,
			);
		}
		$subroutes = $route['subroutes'] ?? null;
		if ( $subroutes ) {
			foreach ( $subroutes as $subroute ) {
				$this->register_subroute( $subroute, $args );
			}
		}
	}

	/**
	 * Registers admin subroute
	 * @param array $subroute Subroute data
	 * @param array $args Parent route data
	 * @return void
	 */
	protected function register_subroute( $subroute, $args ) {
		$subroute_args = $subroute['args'] ?? null;
		if ( $subroute_args ) {
			if ( array_key_exists( 'parent_slug', $subroute_args ) === false ) {
				$subroute_args['parent_slug'] = $args['menu_slug'] ?? null;
			}
			add_submenu_page(
				$subroute_args['parent_slug'] ?? null,
				$subroute_args['page_title'] ?? null,
				$subroute_args['menu_title'] ?? null,
				$subroute_args['capability'] ?? null,
				$subroute_args['menu_slug'] ?? null,
				$subroute_args['callable'] ?? null,
				$subroute_args['icon_url'] ?? null,
				$subroute_args['position'] ?? null,
			);
		}
	}
}
