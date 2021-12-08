<?php

namespace Tokenly\Wp\Routes;

use Tokenly\Wp\Interfaces\Routes\WebRouterInterface;
use Tokenly\Wp\Interfaces\Controllers\Web\UserControllerInterface;
use Tokenly\Wp\Interfaces\Controllers\Web\AuthControllerInterface;
use Tokenly\Wp\Interfaces\Controllers\Web\PostControllerInterface;
use Tokenly\Wp\Interfaces\Models\IntegrationInterface;
use Tokenly\Wp\Interfaces\Models\CurrentUserInterface;
use Tokenly\Wp\Routes\Router;

/**
 * Manages routing for the public views
 */
class WebRouter extends Router implements WebRouterInterface {
	protected $rules = array();
	protected $vars = array();
	protected $routes = array();
	protected $callbacks = array();
	protected $controllers = array();
	protected $auth_controller;
	protected $integration;
	protected $current_user;
	protected $namespace;

	public function __construct(
		UserControllerInterface $user_controller,
		AuthControllerInterface $auth_controller,
		PostControllerInterface $post_controller,
		IntegrationInterface $integration,
		CurrentUserInterface $current_user,
		string $namespace
	) {
		$this->namespace = $namespace;
		$this->auth_controller = $auth_controller;
		$this->controllers = array(
			'auth' => $auth_controller,
			'user' => $user_controller,
			'post' => $post_controller,
		);
		$this->integration = $integration;
		$this->current_user = $current_user;
	}

	/**
	 * Register route service
	 * @return void
	 */
	public function register() {
		$this->register_routes();
	}
	
	protected function can_register( string $key ) {
		if ( $this->integration->can_connect() && $this->current_user->can_connect() ) {
			return true;
		} else {
			return false;
		}
	}

	/**
	 * Get all web route definitions
	 * @return array
	 */
	protected function get_routes() {
		$routes = array(
			'user' => array(
				'rules'     => array(
					'user/(\d+)\/?$',
				),
				'vars'		=> array(
					'user_id' => '$matches[1]',
				),
				'callable'	=> array( $this->controllers['user'], 'show' ),
			),
			'user-me' => array(
				'rules'     => array(
					'user/me',
				),
				'vars'		=> array(
					'user_id' => 'me',
				),
				'callable'	=> array( $this->controllers['user'], 'show' ),
			),
			'oauth-callback' => array(
				'rules'		=> array(
					'oauth/callback/?$',
				),
				'vars'		=> array(
					'oauth_callback' => '1',
				),
				'callable'	=> array( $this->controllers['auth'], 'callback' ),
			),
			'oauth-connect' => array(
				'rules'		=> array(
					'oauth/connect/?$',
				),
				'vars'		=> array(
					'oauth_connect' => '1',
				),
				'callable'	=> array( $this->controllers['auth'], 'store' ),
			),
			'oauth-disconnect' => array(
				'rules'		=> array(
					'oauth/disconnect/?$',
				),
				'vars'		=> array(
					'oauth_disconnect' => '1',
				),
				'callable'	=> array( $this->controllers['auth'], 'destroy' ),
			),
			'access-denied' => array(
				'rules'		=> array(
					'access-denied/?$',
				),
				'vars'		=> array(
					'access_denied' => '1',
				),
				'callable'	=> array( $this->controllers['post'], 'denied' ),
			)
		);
		$routes = $this->prepare_routes( $routes );
		return $routes;
	}

	protected function prepare_routes( array $routes ) {
		foreach ( $routes as $key => &$route ) {
			$vars = $this->prefix_vars( $route['vars'] );
			$rules = $this->process_rules( $route['rules'], $vars );
			$vars = $this->process_vars( $vars );
			$this->rules = array_merge( $this->rules, $rules ?? null );
			$this->vars = array_merge( $this->vars, $vars ?? null );
			$route['rules'] = $rules;
			$route['vars'] = $vars;
			if ( isset( $route['callable'] ) ) {
				$callable = $route['callable'];
				$route['callable'] = function() use ( $callable ) {
					$this->render_route( $callable );
				};
			}
		}
		return $routes;
	}

	protected function process_rules( array $rules, array $vars ) {
		$rules_processed = array();
		foreach ( $rules as $rule ) {
			$new_key = "{$this->namespace}/{$rule}";
			$new_rule = 'index.php';
			if ( count( $vars ) > 0 ) {
				$first = true;
				foreach ( $vars as $key => $var ) {
					$new_rule .= $first ? '?' : '&';
					$new_rule = "{$new_rule}{$key}={$var}";
					$first = false;
				}
			}
			$rules_processed[ $new_key ] = $new_rule;
		}
		return $rules_processed;
	}
	
	protected function process_vars( array $vars ) {
		$vars_processed = array();
		foreach ( $vars as $key => $var ) {
			$vars_processed[] = $key;
		}
		return $vars_processed;
	}

	protected function prefix_vars( array $vars ) {
		$vars_prefixed = array();
		foreach ( $vars as $key => $var ) {
			$new_key = "{$this->namespace}_{$key}";
			$vars_prefixed[ $new_key ] = $var;
		}
		return $vars_prefixed;
	}
	/**
	 * Merges the web route rewrite rules with the rest
	 * of WordPress rewrite rules
	 * @wp-hook generate_rewrite_rules
	 * @return void
	 */
	public function merge_rewrite_rules( $wp_rewrite ) {
		$rules_formatted = array();
		foreach ( $this->rules as $key => $rule ) {
			$rule = "{$rule}&{$this->namespace}_virtual=1";
			$rules_formatted[ $key ] = $rule;
		}
		$wp_rewrite->rules = array_merge(
			$rules_formatted,
			$wp_rewrite->rules
		);
	}

	/**
	 * Gets the template callback for
	 * the current route
	 * @wp-hook template_include
	 * @return callable
	 */
	public function find_template( $template ) {
		foreach ( $this->routes as $route ) {
			if ( !isset( $route['vars'] ) ) {
				continue;
			}
			$query_vars = $route['vars'] ?? null;
			foreach ( $query_vars as $query_var ) {
				$query_var = get_query_var( $query_var );
				if ( $query_var ) {
					if ( !isset( $route['callable'] ) ) {
						continue;
					}
					$callback = $route['callable'] ?? null;
					return call_user_func( $callback );
				}
			}
		}
		return $template;
	}

	/**
	 * Registers all web routes
	 * @return void
	 */
	public function register_routes() {
		$this->routes = $this->get_routes();
		add_filter( 'generate_rewrite_rules', array( $this, 'merge_rewrite_rules' ) );
		add_filter( 'template_include', array( $this, 'find_template' ) );
	}
}
