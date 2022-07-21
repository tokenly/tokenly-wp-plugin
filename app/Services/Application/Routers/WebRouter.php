<?php

namespace Tokenly\Wp\Services\Application\Routers;

use Tokenly\Wp\Services\Application\Routers\Router;
use Tokenly\Wp\Interfaces\Services\Application\Routers\WebRouterInterface;

use Tokenly\Wp\Interfaces\Models\IntegrationInterface;
use Twig\Environment;
use Tokenly\Wp\Interfaces\Repositories\Routes\WebRouteRepositoryInterface;
use Tokenly\Wp\Interfaces\Models\Routes\RouteInterface;
use Tokenly\Wp\Interfaces\Collections\Routes\RouteCollectionInterface;

/**
 * Manages routing for the public views
 */
class WebRouter extends Router implements WebRouterInterface {
	protected array $rules = array();
	protected array $vars = array();
	protected array $callbacks = array();
	protected array $controllers = array();
	protected string $namespace;
	protected Environment $twig;
	protected string $default_template = 'Index.twig';
	protected WebRouteRepositoryInterface $web_route_repository;

	public function __construct(
		Environment $twig,
		string $namespace,
		WebRouteRepositoryInterface $web_route_repository
	) {
		$this->namespace = $namespace;
		$this->twig = $twig;
		$this->web_route_repository = $web_route_repository;
	}

	/**
	 * @inheritDoc
	 */
	public function register(): void {
		$this->routes = $this->web_route_repository->index();
		parent::register();
		$this->routes = $this->process_routes( $this->routes );
		add_filter(
			'generate_rewrite_rules',
			array( $this, 'merge_rewrite_rules' )
		);
		add_filter( 'template_include', array( $this, 'find_template' ) );
	}

	/**
	 * @inheritDoc
	 */
	protected function process_routes(
		RouteCollectionInterface $routes
	): RouteCollectionInterface {
		foreach ( $routes as $key => &$route ) {
			$vars = $this->prefix_vars( $route->vars );
			$rules = $this->process_rules( $route->rules, $vars );
			$vars = $this->process_vars( $vars );
			$this->rules = array_merge( $this->rules, $rules ?? null );
			$this->vars = array_merge( $this->vars, $vars ?? null );
			$route->rules = $rules;
			$route->vars = $vars;
			if ( $route->callback ) {
				$callback = $route->callback;
				$route->callback = function() use ( $callback ) {
					$this->render_route( $callback );
				};
			}
			$routes[ $key ] = $route;
		}
		return $routes;
	}

	protected function process_rules(
		array $rules = array(),
		array $vars = array()
	): array {
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
	
	protected function process_vars( array $vars = array() ): array {
		$vars_processed = array();
		foreach ( $vars as $key => $var ) {
			$vars_processed[] = $key;
		}
		return $vars_processed;
	}

	/**
	 * Prefixes the query variables associated with the routes
	 * @param string[] $vars Query variables
	 * @return string[]
	 */
	protected function prefix_vars( array $vars = array() ): array {
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
	public function merge_rewrite_rules( $wp_rewrite ): void {
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
	 * @return string|null
	 */
	public function find_template( $template ): ?string {
		foreach ( $this->routes as $route ) {
			if ( !$route->id || !$route->callback ) {
				continue;
			}
			$id = $route->id;
			$route_var = "{$this->namespace}_{$id}_page";
			$query_var = get_query_var( $route_var );
			if ( $query_var ) {
				$callback = $route->callback;
				return call_user_func( $callback );
			}
		}
		return $template;
	}
}
