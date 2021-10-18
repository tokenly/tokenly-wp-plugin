<?php

namespace Tokenly\Wp\Routes;

use Tokenly\Wp\Controllers\Web\UserController;

class WebRouter {
	public function boot() {
		add_filter( 'generate_rewrite_rules', function ( $wp_rewrite ){
			$wp_rewrite->rules = array_merge(
				['tokenly-user/(\d+)\/?$' => 'index.php?tokenly_user_id=$matches[1]'],
				$wp_rewrite->rules
			);
		} );
		add_filter( 'query_vars', function( $query_vars ){
			$query_vars[] = 'tokenly_user_id';
			return $query_vars;
		} );
		add_filter( 'template_include', function( $template ) {
			$tokenly_user_id = intval( get_query_var( 'tokenly_user_id' ) );
			if ( $tokenly_user_id ) {
				return TOKENLY_PLUGIN_DIR . 'resources/views/user.php';
			}
		} );
	}

	public function get_routes() {
		return array(
			'tokenly-user' => array(
				'rules'     => array(
					'tokenly-user/(\d+)\/?$' => 'index.php?tokenly_user_id=$matches[1]',
				),
				'vars'		=> array(
					'tokenly_user_id',
				),
				'callback'	=> array( new UserController(), 'show' ),
			),
		);
	}

	public function merge_rewrite_rules( $wp_rewrite ) {
		$wp_rewrite->rules = array_merge(
			$rules,
			$wp_rewrite->rules
		);
	}

	public function merge_query_vars( $query_vars ) {
		$query_vars = array_merge( $query_vars, $vars );
		return $query_vars;
	}

	public function register_routes() {
		$this->routes = $this->get_routes();
		$this->rules = array();
		$this->vars = array();
		foreach ( $routes as $route ) {
			$this->rules = array_merge( $this->rules, $route['rules'] ?? null );
			$this->vars = array_merge( $this->vars, $route['vars'] ?? null );
		}
		add_filter( 'generate_rewrite_rules', array( $this, 'merge_rewrite_rules' ) );
		add_filter( 'query_vars', array( $this, 'merge_query_vars' ) );
		add_filter( 'template_include', function( $template ) { });
	}
}
