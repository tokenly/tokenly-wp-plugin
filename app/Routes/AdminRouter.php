<?php

namespace Tokenly\Wp\Routes;

use Tokenly\Wp\Controllers\Web\Admin\DashboardController;
use Tokenly\Wp\Controllers\Web\Admin\VendorController;
use Tokenly\Wp\Controllers\Web\Admin\WhitelistController;
use Tokenly\Wp\Controllers\Web\Admin\ConnectionController;
use Tokenly\Wp\Controllers\Web\Admin\SettingsController;

class AdminRouter {
	public $routes;

	public function boot() {
		$this->routes = $this->get_routes();
		add_action( 'admin_menu', array( $this, 'register_routes' ) );
	}

	public function get_routes() {
		$routes = array(
			'tokenpass' => array(
				'args'    => array(
					'page_title' => 'Tokenpass',
					'menu_title' => 'Tokenpass',
					'menu_slug'  => 'tokenpass',
					'callable'   => array( new DashboardController(), 'show' ),
					'capability' => 'manage_options',
					'icon_url'   => 'data:image/svg+xml;base64,' . base64_encode( file_get_contents( plugin_dir_url( __FILE__ ) . '../../resources/images/tokenly_logo.svg' ) ),
					'position'   => 3,
				),
				'subroutes'   => array(
					'vendor' => array(
						'args'      => array(
							'page_title' => 'Tokenly Vendor',
							'menu_title' => 'Vendor',
							'menu_slug'  => 'vendor',
							'callable'   => array( new VendorController(), 'show' ),
							'capability' => 'manage_options',
						),
					),
					'whitelist' => array(
						'args'      => array(
							'page_title' => 'Gallery Token Whitelist',
							'menu_title' => 'Whitelist',
							'menu_slug'  => 'whitelist',
							'callable'   => array( new WhitelistController(), 'show' ),
							'capability' => 'manage_options',
						),
					),
					'connection' => array(
						'args'      => array(
							'page_title' => 'Connection Status',
							'menu_title' => 'Connection',
							'menu_slug'  => 'connection',
							'callable'   => array( new ConnectionController(), 'show' ),
							'capability' => 'manage_options',
						),
					),
					'settings' => array(
						'args'      => array(
							'page_title' => 'Settings',
							'menu_title' => 'Settings',
							'menu_slug'  => 'settings',
							'callable'   => array( new SettingsController(), 'show' ),
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
			return implode( '-', array( $route_slug, $subroute_slug ) );
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
