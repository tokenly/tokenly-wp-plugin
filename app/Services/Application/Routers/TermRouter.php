<?php

namespace Tokenly\Wp\Services\Application\Routers;

use Tokenly\Wp\Services\Application\Routers\Router;
use Tokenly\Wp\Interfaces\Services\Application\Routers\TermRouterInterface;

use Twig\Environment;
use Tokenly\Wp\Interfaces\Models\TermInterface;
use Tokenly\Wp\Interfaces\Repositories\Routes\TermRouteRepositoryInterface;
use Tokenly\Wp\Interfaces\Models\Routes\RouteInterface;
use Tokenly\Wp\Interfaces\Collections\Routes\RouteCollectionInterface;

/**
 * Manages routing for the post type views
 */
class TermRouter extends Router implements TermRouterInterface {
	protected string $namespace;
	protected string $brand;
	protected Environment $twig;
	/**
	 * @var array $registered Is used to prevent registration of multiple
	 * routes for the same post type
	 */
	protected array $registered = array();
	protected string $default_template = 'Dynamic.twig';
	protected TermRouteRepositoryInterface $term_route_repository;
	
	public function __construct(
		string $namespace,
		string $brand,
		Environment $twig,
		TermRouteRepositoryInterface $term_route_repository
	) {
		$this->namespace = $namespace;
		$this->brand = $brand;
		$this->twig = $twig;
		$this->term_route_repository = $term_route_repository;
	}

	/**
	 * @inheritDoc
	 */
	public function register( array $routes = array() ): void {
		$this->routes = $this->term_route_repository->index();
		$this->register_routes();
	}

	/**
	 * @inheritDoc
	 */
	public function register_routes(): void {
		foreach ( ( array ) $this->routes as $route ) {
			if ( !$route->taxonomy ) {
				$taxonomies = get_taxonomies();
			} else {
				$taxonomies = $route->taxonomy;
			}
			foreach ( $taxonomies as $taxonomy ) {
				if ( in_array( $taxonomy, $this->registered ) ) {
					continue;
				}
				$this->register_route( $taxonomy, $route );
			}
		}
	}

	/**
	 * Registers the route
	 * @param string $post_type Route post type
	 * @param RouteInterface $route Route data
	 * @return void
	 */
	public function register_route(
		string $taxonomy,
		RouteInterface $route
	): void {
		if ( is_admin() ) {
			$this->register_edit_callback( $taxonomy, $route );
			$this->register_update_callback( $taxonomy, $route );
		} else {
			$this->register_show_callback( $taxonomy, $route );
		}
		$this->registered[] = $taxonomy;
	}

	protected function get_route_by_taxonomy(
		string $search_taxonomy
	): ?array {
		foreach ( $this->routes as $route ) {
			$taxonomies = array();
			if ( $route->taxonomy && is_array( $route->taxonomy ) ) {
				$taxonomies = $route->taxonomy;
			} else {
				$taxonomies = get_taxonomies();
			}
			foreach ( $taxonomies as $taxonomy ) {
				if ( $search_taxonomy == $taxonomy ) {
					return $route;
				}
			}
		}
	}


	/**
	 * Formats the Show route callback
	 * @param string $post_type Route post type
	 * @param array $route Route data
	 * @return void 
	 */
	protected function register_show_callback(
		string $taxonomy,
		RouteInterface $route
	): void {
		if ( $route->show_callback ) {
			$callback = $route->show_callback;
			$route->show_callback = function( TermInterface $term ) use ( $callback ) {
				$this->render_route( $callback, array( $term ) );
			};
			$action = "{$this->namespace}_template_redirect_term_{$taxonomy}";
			$callback = function(
				TermInterface $term
			) use ( $route, $taxonomy ) {
				$callback = $route->show_callback;
				call_user_func( $callback, $term );
				exit;
			};
			add_action( $action, $callback, 100, 1 );
		}
	}

	/**
	 * Formats the Edit route callback
	 * @param string $post_type Route post type
	 * @param RouteInterface $route Route data
	 * @return void 
	 */
	protected function register_edit_callback(
		string $taxonomy,
		RouteInterface $route
	): void {
		$action = "{$this->namespace}_{$taxonomy}_edit_form";
		$callback = function( TermInterface $term ) use ( $route ) {
			$callback = $route->edit_callback;
			$this->render_route( $callback, array( $term ) );
		};
		add_action( $action, $callback, 10, 1 );
	}

	protected function register_update_callback(
		string $taxonomy,
		RouteInterface $route
	): void {
		$update_callback = $route->update_callback;
		$action = "{$this->namespace}_saved_{$taxonomy}";
		$callback = function(
			TermInterface $term,
			bool $update
		) use ( $route, $taxonomy, $update_callback ) {
			if ( !$this->request_params_present() ) {
				return;
			}
			if ( $route ) {
				$params = $this->get_request_params();
				call_user_func( $route->update_callback, $term, $params );
			}
		};
		add_action( $action, $callback, 10, 2 );
	}
}
