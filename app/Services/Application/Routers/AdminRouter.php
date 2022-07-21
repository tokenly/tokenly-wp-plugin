<?php

namespace Tokenly\Wp\Services\Application\Routers;

use Tokenly\Wp\Services\Application\Routers\Router;
use Tokenly\Wp\Interfaces\Services\Application\Routers\AdminRouterInterface;

use Tokenly\Wp\Interfaces\Services\Application\AuthServiceInterface;
use Tokenly\Wp\Interfaces\Repositories\UserRepositoryInterface;
use Tokenly\Wp\Interfaces\Models\IntegrationInterface;
use Tokenly\Wp\Interfaces\Models\UserInterface;
use Tokenly\Wp\Interfaces\Controllers\Admin\UserControllerInterface;
use Tokenly\Wp\Interfaces\Repositories\Routes\AdminRouteRepositoryInterface;
use Twig\Environment;
use Tokenly\Wp\Interfaces\Models\Routes\RouteInterface;
use Tokenly\Wp\Interfaces\Collections\Routes\RouteCollectionInterface;

/**
 * Manages routing for the WordPress admin pages
 * The responses from the controllers are routed back to the router.
 * It is to render the views since every response is the same
 * (render dynamic view) and only the data is different. All admin routes are
 * rendered by client so there is no need for more than one template.
 */
class AdminRouter extends Router implements AdminRouterInterface {
	protected AuthServiceInterface $auth_service;
	protected ?IntegrationInterface $integration;
	protected UserRepositoryInterface $user_repository;
	protected UserControllerInterface $user_controller;
	protected AdminRouteRepositoryInterface $admin_route_repository;
	protected string $namespace;
	protected Environment $twig;
	protected string $default_template = 'Dynamic.twig';

	public function __construct(
		string $namespace,
		AuthServiceInterface $auth_service,
		UserRepositoryInterface $user_repository,
		UserControllerInterface $user_controller,
		Environment $twig,
		AdminRouteRepositoryInterface $admin_route_repository
	) {
		$this->namespace = $namespace;
		$this->integration = null;
		$this->user_repository = $user_repository;
		$this->current_user = $this->user_repository->show_current();
		$this->auth_service = $auth_service;
		$this->user_controller = $user_controller;
		$this->twig = $twig;
		$this->admin_route_repository = $admin_route_repository;
	}

	/**
	 * @inheritDoc
	 */
	public function register(): void {
		$this->routes = clone $this->admin_route_repository->index();
		$this->routes = $this->process_routes( $this->routes );
		add_action( 'admin_menu', array( $this, 'register_routes' ) );
		add_action(
			"{$this->namespace}_show_user_profile",
			function( UserInterface $user ) {
				$this->render_route(
					array( $this->user_controller, 'show' ),
					array( $user )
				);
			}, 10, 1
		);
	}

	/**
	 * Hooks the router to WordPress
	 * @return void
	 */
	public function register_routes(): void {
		foreach ( $this->routes as $key => $route ) {
			$this->register_route( $key, $route );
		}
	}
	
	/**
	 * @inheritDoc
	 */
	protected function can_register( RouteInterface $route ): bool {
		return ( $this->admin_route_repository->get_can_register( $route ) );
	}

	/**
	 * @inheritDoc
	 */
	protected function process_routes(
		RouteCollectionInterface $routes
	): RouteCollectionInterface {
		foreach ( ( array ) $routes as $key => $route ) {
			$routes[ $key ] = $this->process_route( $routes[ $key ] );
			$routes[ $key ] = $this->process_subroutes( $routes[ $key ] );
		}
		return $routes;
	}

	/**
	 * Prepares a group of subroutes before rendering
	 * @param RouteInterface $route
	 * @return RouteInterface $route
	 */
	protected function process_subroutes(
		RouteInterface $route
	): RouteInterface {
		if ( $route->subroutes ) {
			$subroutes = $route->subroutes;
			foreach ( ( array ) $subroutes as &$subroute ) {
				$subroute = $this->process_subroute( $route, $subroute );
			}
			$route->subroutes = $subroutes;
		}
		return $route;
	}

	/**
	 * Prepares a single subroute before rendering
	 * @param RouteInterface $route Parent route data
	 * @param RouteInterface $subroute Subroute data
	 * @return array
	 */
	protected function process_subroute(
		RouteInterface $route,
		RouteInterface $subroute
	): RouteInterface {
		$subroute = $this->process_route( $subroute );
		$menu_slug = $this->get_subroute_slug( $route, $subroute );
		$subroute->menu_slug = $menu_slug;
		return $subroute;
	}

	/**
	 * Prepare a single route before rendering
	 * @param RouteInterface $route Route data
	 * @return array
	 */
	protected function process_route(
		RouteInterface $route
	): RouteInterface {
		if ( $route->callable ) {
			$callable = $route->callable;
			$route->callable = function() use ( $callable ) {
				$this->render_route( $callable );
			};
		}
		return $route;
	}

	/**
	 * Prefixes the child route slug with the parent's slug
	 * @param RouteInterface $route Parent route
	 * @param RouteInterface $subroute Child route
	 * @return string
	 */
	protected function get_subroute_slug(
		RouteInterface $route,
		RouteInterface $subroute
	): string {
		if ( !$route->menu_slug || !$subroute->menu_slug ) {
			throw new \Exception( 'Missing route or subroute slug.' );
		}
		$route_slug = $route->menu_slug;
		$subroute_slug = $subroute->menu_slug;
		return implode( '-', array( $route_slug, $subroute_slug ) );
	}

	/**
	 * @inheritDoc
	 */
	public function register_route(
		string $key,
		RouteInterface $route
	): void {
		if ( $this->can_register( $route ) === true ) {
			add_menu_page(
				$route->page_title,
				$route->menu_title,
				$route->capability ?? 'manage_options',
				$route->menu_slug,
				$route->callable,
				$route->icon_url,
				$route->position,
			);
		}
		if ( $route->subroutes ) {
			$subroutes = $route->subroutes;
			foreach ( ( array ) $subroutes as $key => $subroute ) {
				$this->register_subroute( $key, $subroute, $route );
			}
		}
	}

	/**
	 * Registers admin subroute
	 * @param RouteInterface $subroute Subroute data
	 * @param RouteInterface $route Parent route data
	 * @return void
	 */
	protected function register_subroute(
		string $key,
		RouteInterface $subroute,
		RouteInterface $route
	): void {
		if ( $subroute->parent_slug === null ) {
			$subroute->parent_slug = $route->menu_slug;
		}
		if ( $this->can_register( $subroute ) === false ) {
			return;
		}
		add_submenu_page(
			$subroute->parent_slug,
			$subroute->page_title,
			$subroute->menu_title,
			$subroute->capability,
			$subroute->menu_slug,
			$subroute->callable,
			$subroute->icon_url,
			$subroute->position,
		);
	}
}
