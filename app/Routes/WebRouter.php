<?php

namespace Tokenly\Wp\Routes;

use Tokenly\Wp\Interfaces\Routes\WebRouterInterface;
use Tokenly\Wp\Interfaces\Controllers\Web\UserControllerInterface;
use Tokenly\Wp\Interfaces\Controllers\Api\AuthControllerInterface;

/**
 * Manages routing for the public views
 */
class WebRouter implements WebRouterInterface {
	protected $rules = array();
	protected $vars = array();
	protected $routes = array();
	protected $callbacks = array();
	protected $controllers = array();
	protected $auth_controller;

	public function __construct(
		UserControllerInterface $user_controller,
		AuthControllerInterface $auth_controller
	) {
		$this->auth_controller = $auth_controller;
		$this->controllers = array(
			'auth' => $auth_controller,
			'user' => $user_controller,
		);
	}

	/**
	 * Register route service
	 * @return void
	 */
	public function register() {
		$this->register_routes();
	}

	/**
	 * Get all web route definitions
	 * @return array
	 */
	protected function get_routes() {
		return array(
			'tokenly-user' => array(
				'rules'     => array(
					'tokenpass-user/(\d+)\/?$' => 'index.php?tokenpass_user_id=$matches[1]',
				),
				'vars'		=> array(
					'tokenpass_user_id',
				),
				'callback'	=> array( $this->controllers['user'], 'show' ),
			),
			'tokenly-user-me' => array(
				'rules'     => array(
					'tokenpass-user/me' => 'index.php?tokenpass_user_id=me',
				),
				'vars'		=> array(
					'tokenpass_user_id',
				),
				'callback'	=> array( $this->controllers['user'], 'show' ),
			),
			'tokenpass-oauth-callback' => array(
				'rules'		=> array(
					'tokenpass-oauth-callback/?$' => 'index.php?tokenpass-oauth-callback=1',
				),
				'vars'		=> array(
					'tokenpass-oauth-callback',
				),
				'callback'	=> array( $this->controllers['auth'], 'authorize_callback' ),
			)
		);
	}

	/**
	 * Merges the web route rewrite rules with the rest
	 * of WordPress rewrite rules
	 * @wp-hook generate_rewrite_rules
	 * @return void
	 */
	public function merge_rewrite_rules( $wp_rewrite ) {
		$wp_rewrite->rules = array_merge(
			$this->rules,
			$wp_rewrite->rules
		);
	}

	/**
	 * Merges the web route query vars with the rest
	 * of WordPress query vars
	 * @wp-hook query_vars
	 * @return array
	 */
	public function merge_query_vars( $query_vars ) {
		$query_vars = array_merge( $query_vars, $this->vars );
		return $query_vars;
	}

	/**
	 * Gets the template callback for
	 * the current route
	 * @wp-hook template_include
	 * @return callable
	 */
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

	/**
	 * Registers all web routes
	 * @return void
	 */
	protected function register_routes() {
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
