<?php

namespace Tokenly\Wp\Routes;

use Tokenly\Wp\Services\AuthService;

use Tokenly\Wp\Controllers\Web\Admin\DashboardController;
use Tokenly\Wp\Controllers\Web\Admin\VendorController;
use Tokenly\Wp\Controllers\Web\Admin\WhitelistController;
use Tokenly\Wp\Controllers\Web\Admin\ConnectionController;
use Tokenly\Wp\Controllers\Web\Admin\SettingsController;

class AdminRouter {
	public $routes;
	public $redirects = array();

	public function __construct(
		AuthService $auth_service,
		
		DashboardController $dashboard_controller,
		VendorController $vendor_controller,
		WhitelistController $whitelist_controller,
		ConnectionController $connection_controller,
		SettingsController $settings_controller
	) {
		$this->auth_service =$auth_service;
		$this->controllers = array(
			'dashboard'  => $dashboard_controller,
			'vendor'     => $vendor_controller,
			'whitelist'  => $whitelist_controller,
			'connection' => $connection_controller,
			'settings'   => $settings_controller
		);
	}

	public function register() {
		$this->routes = $this->get_routes();
		add_action( 'admin_menu', array( $this, 'register_routes' ) );
		add_action( 'admin_print_scripts', array( $this,  'add_redirects' ) );
	}

	public function add_redirects() {
		$id = get_current_user_id();
		echo "	
			<script type='text/javascript'>
				window.tokenpassRedirects = [
					{
						from: 'tokenpass-inventory',
						to: '/tokenpass-user/{$id}',
					},
					{
						from: 'tokenpass-dashboard',
						to: 'https://tokenpass.tokenly.com/dashboard',
					},
				];
			</script>
		"; 
	}
	
	public function can_view_inventory() {
		if ( current_user_can( 'read' ) === true && $this->auth_service->is_connected() === true ) {
			return true;
		} else {
			return false;
		}
	}

	public function get_routes() {
		$routes = array(
			'tokenpass' => array(
				'args'    => array(
					'page_title' => 'Tokenpass',
					'menu_title' => 'Tokenpass',
					'menu_slug'  => 'tokenpass',
					'callable'   => array( $this->controllers['dashboard'], 'show' ),
					'capability' => 'manage_options',
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

	public function prepare_routes( $routes ) {
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

	public function get_subroute_slug( $route, $subroute ) {
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
	
	public function register_routes() {
		foreach ( $this->routes as $route ) {
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
					$subroute_args = $subroute['args'] ?? null;
					if ( $subroute_args ) {
						add_submenu_page(
							$args['menu_slug']  ?? null,
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
		}
	}
}
