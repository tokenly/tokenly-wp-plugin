<?php

namespace Tokenly\Wp\Services\Application\Routers;

use Tokenly\Wp\Services\Application\Routers\Router;
use Tokenly\Wp\Interfaces\Services\Application\Routers\PostRouterInterface;

use Tokenly\Wp\Interfaces\Factories\Collections\PostCollectionFactoryInterface;
use Twig\Environment;
use Tokenly\Wp\Interfaces\Models\PostInterface;
use Tokenly\Wp\Interfaces\Repositories\Routes\PostRouteRepositoryInterface;
use Tokenly\Wp\Interfaces\Models\Routes\RouteInterface;
use Tokenly\Wp\Interfaces\Collections\Routes\RouteCollectionInterface;

/**
 * Manages routing for the post type views
 */
class PostRouter extends Router implements PostRouterInterface {
	protected string $brand;
	protected string $default_template = 'Dynamic.twig';
	protected PostRouteRepositoryInterface $post_route_repository;
	/**
	 * @var array $registered Is used to prevent registration
	 * of multiple routes for the same post type
	 */
	protected array $registered = array();
	public function __construct(
		Environment $twig,
		string $namespace,
		string $brand,
		PostRouteRepositoryInterface $post_route_repository
	) {
		parent::__construct( $namespace );
		$this->brand = $brand;
		$this->twig = $twig;
		$this->post_route_repository = $post_route_repository;
	}

	/**
	 * @inheritDoc
	 */
	public function register(): void {
		$this->routes = $this->post_route_repository->index();
		$this->register_routes();
	}

	/**
	 * Registers all routes
	 * @return void
	 */
	public function register_routes(): void {
		foreach ( ( array ) $this->routes as $route ) {
			if ( !$route->post_type ) {
				$post_types = get_post_types();
			} else {
				$post_types = $route->post_type;
			}
			foreach ( $post_types as $post_type ) {
				if ( in_array( $post_type, $this->registered ) ) {
					continue;
				}
				$this->register_route( $post_type, $route );
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
		string $post_type ,
		RouteInterface $route
	): void {
		if ( is_admin() ) {
			$this->register_edit_callback( $post_type, $route );
		} else {
			$this->register_show_callback( $post_type, $route );
		}
		$this->registered[] = $post_type;
	}

	/**
	 * Formats the Show route callback
	 * @param string $post_type Route post type
	 * @param array $route Route data
	 * @return void 
	 */
	protected function register_show_callback(
		string $post_type,
		RouteInterface $route
	): void {
		if ( $route->show_callback ) {
			$callback = $route->show_callback;
			$callback = function( PostInterface $post ) use ( $callback ) {
				$this->render_route( $callback, array( $post ) );
			};
			$route->show_callback = $callback;
			$action = "{$this->namespace}_template_redirect_post_{$post_type}";
			$action_callback = function(
				PostInterface $post
			) use ( $route, $post_type ) {
				$callback = $route->show_callback;
				call_user_func( $callback, $post );
				exit;
			};
			add_action( $action, $action_callback, 100, 1 );
		}
	}

	/**
	 * Formats the Edit route callback
	 * @param string $post_type Route post type
	 * @param RouteInterface $route Route data
	 * @return void 
	 */
	protected function register_edit_callback(
		string $post_type,
		RouteInterface $route
	): void {
		$action = "{$this->namespace}_add_meta_boxes_{$post_type}";
		$callback = function( PostInterface $post ) use ( $route ) {
			add_meta_box(
				"{$this->namespace}-data",
				$this->brand,
				function() use ( $route, $post ) {
					$edit_callback = $route->edit_callback;
					$this->render_route( $edit_callback, array( $post ) );
				}, $post->post_type, 'advanced', 'high'
			);
		};
		add_action( $action, $callback );
		$update_callback = $route->update_callback;
		$action = "{$this->namespace}_save_post_{$post_type}";
		$callback = function(
			PostInterface $post,
			bool $update
		) use ( $update_callback ) {
			if ( !$this->request_params_present() ) {
				return;
			}
			$params = $this->get_request_params();
			call_user_func( $update_callback, $post, $params );
		};
		add_action( $action, $callback, 10, 2 );
	}
}
