<?php

namespace Tokenly\Wp\Routes;

use Tokenly\Wp\Controllers\Web\UserController;

class WebRouter {
	public $rules = array();
	public $vars = array();
	public $routes = array();
	public $callbacks = array();
	public $controllers = array();

	public function __construct(
		UserController $user_controller
	) {
		$this->controllers = array(
			'user' => $user_controller,
		);
	}

	public function register() {
		$this->register_routes();
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
				'callback'	=> array( $this->controllers['user'], 'show' ),
			),
		);
	}

	public function merge_rewrite_rules( $wp_rewrite ) {
		$wp_rewrite->rules = array_merge(
			$this->rules,
			$wp_rewrite->rules
		);
	}

	public function merge_query_vars( $query_vars ) {
		$query_vars = array_merge( $query_vars, $this->vars );
		return $query_vars;
	}

	public function find_template( $template ) {
		foreach ( $this->routes as $route ) {
			$query_vars = $route['vars'] ?? null;
			if ( $query_vars ) {
				foreach ( $query_vars as $query_var ) {
					$query_var = get_query_var( $query_var );
					if ( $query_var ) {
						$callback = $route['callback'] ?? null;
						if ( $callback ) {
							return call_user_func( $callback );
						}
					}
				}
			}
		}
		return $template;
	}

	public function register_routes() {
		$this->routes = $this->get_routes();
		foreach ( $this->routes as $route ) {
			$this->rules = array_merge( $this->rules, $route['rules'] ?? null );
			$this->vars = array_merge( $this->vars, $route['vars'] ?? null );
			$this->callbacks[] = $route['callback'] ?? null;
		}
		add_filter( 'generate_rewrite_rules', array( $this, 'merge_rewrite_rules' ) );
		add_filter( 'query_vars', array( $this, 'merge_query_vars' ) );
		add_filter( 'template_include', array( $this, 'find_template' ) );
	}
}
