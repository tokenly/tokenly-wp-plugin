<?php

namespace Tokenly\Wp\Routes;

use Tokenly\Wp\Admin\TokenpassPage;
use Tokenly\Wp\Admin\Tokenpass\TokenpassVendorPage;
use Tokenly\Wp\Admin\Tokenpass\TokenpassWhitelistPage;
use Tokenly\Wp\Admin\Tokenpass\TokenpassConnectionPage;
use Tokenly\Wp\Admin\Tokenpass\TokenpassSettingsPage;

class AdminRouter {
	public $routes;

	public function register() {
		$this->routes = $this->get_routes();
		add_action( 'admin_menu', array( $this, 'register_routes' ) );
		add_action( 'admin_init', array( $this, 'register_settings' ) );
	}

	public function get_routes() {
		return [
			'tokenpass' => array(
				'args'    => array(
					'page_title' => 'Tokenpass',
					'menu_title' => 'Tokenpass',
					'menu_slug'  => 'tokenpass',
					'callable'   => TokenpassPage::class,
					'capability' => 'manage_options',
					'icon_url'   => 'data:image/svg+xml;base64,' . base64_encode( file_get_contents( plugin_dir_url( __FILE__ ) . '../../assets/images/tokenly_logo.svg' ) ),
					'position'   => 3,
				),
				'subroutes'   => array(
					'vendor' => array(
						'args'      => array(
							'page_title' => 'Vendor',
							'menu_title' => 'Vendor',
							'menu_slug'  => 'vendor',
							'callable'   => TokenpassVendorPage::class,
							'capability' => 'manage_options',
						),
					),
					'whitelist' => array(
						'args'      => array(
							'page_title' => 'Whitelist',
							'menu_title' => 'Whitelist',
							'menu_slug'  => 'whitelist',
							'callable'   => TokenpassWhitelistPage::class,
							'capability' => 'manage_options',
						),
					),
					'connection' => array(
						'args'      => array(
							'page_title' => 'Connection',
							'menu_title' => 'Connection',
							'menu_slug'  => 'connection',
							'callable'   => TokenpassConnectionPage::class,
							'capability' => 'manage_options',
						),
					),
					'settings' => array(
						'args'      => array(
							'page_title' => 'Settings',
							'menu_title' => 'Settings',
							'menu_slug'  => 'settings',
							'callable'   => TokenpassSettingsPage::class,
							'capability' => 'manage_options',
						),
					),
				),
			),
		];
	}

	public function get_route_callback( $route_args ) {
		$callable = $route_args['callable'] ?? null;
		if ( $callable ) {
			$callable = array( new $callable( $route_args ), 'page_callback' );
		}
		return $callable;
	}

	public function get_subpage_menu_slug( $args, $subroute_args ) {
		$parent_slug = $args['menu_slug'] ?? null;
		$slug = $subroute_args['menu_slug'] ?? null;
		return implode( '-', array( $parent_slug, $slug ) );
	}
	
	public function register_routes() {
		foreach ( $this->routes as $route ) {
			$args = $route['args'] ?? null;
			if ( $args ) {
				$callable = $this->get_route_callback( $args );
				add_menu_page(
					$args['page_title'] ?? null,
					$args['menu_title'] ?? null,
					$args['capability'] ?? null,
					$args['menu_slug'] ?? null,
					$callable,
					$args['icon_url'] ?? null,
					$args['position'] ?? null,
				);
			}
			$subroutes = $route['subroutes'] ?? null;
			if ( $subroutes ) {
				foreach ( $subroutes as $subroute ) {
					$subroute_args = $subroute['args'] ?? null;
					if ( $subroute_args ) {
						$subroute_args['menu_slug'] = $this->get_subpage_menu_slug( $args, $subroute_args );
						$callable = $this->get_route_callback( $subroute_args );
						add_submenu_page(
							$args['menu_slug']  ?? null,
							$subroute_args['page_title'] ?? null,
							$subroute_args['menu_title'] ?? null,
							$subroute_args['capability'] ?? null,
							$subroute_args['menu_slug'],
							$callable,
							$subroute_args['icon_url'] ?? null,
							$subroute_args['position'] ?? null,
						);
					}
				}
			}
		}
	}

	public function register_route_settings( $route ) {
		$args = $route['args'] ?? null;
		if ( $args ) {
			$callable = $args['callable'] ?? null;
			if ( $callable ) {
				$callable = new $callable( $args );
				$callable->register_settings();
			}
		}
	}

	public function register_settings() {
		foreach ( $this->routes as $route ) {
			$this->register_route_settings( $route );
			$subroutes = $route['subroutes'] ?? null;
			if ( $subroutes ) {
				foreach ( $subroutes as $subroute ) {
					$subroute['args']['menu_slug'] = $this->get_subpage_menu_slug($route['args'], $subroute['args']);
					$this->register_route_settings( $subroute );
				}
			}
		}
	}
}
