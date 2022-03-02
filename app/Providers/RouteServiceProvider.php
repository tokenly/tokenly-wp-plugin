<?php

namespace Tokenly\Wp\Providers;

use Tokenly\Wp\Providers\ServiceProvider;
use Tokenly\Wp\Interfaces\Providers\RouteServiceProviderInterface;

use Tokenly\Wp\Interfaces\Services\Application\Routers\AdminRouterInterface;
use Tokenly\Wp\Interfaces\Services\Application\Routers\ApiRouterInterface;
use Tokenly\Wp\Interfaces\Services\Application\Routers\PostRouterInterface;
use Tokenly\Wp\Interfaces\Services\Application\Routers\TermRouterInterface;
use Tokenly\Wp\Interfaces\Services\Application\Routers\WebRouterInterface;
use Tokenly\Wp\Interfaces\Repositories\Routes\AdminRouteRepositoryInterface;
use Tokenly\Wp\Interfaces\Repositories\Routes\ApiRouteRepositoryInterface;
use Tokenly\Wp\Interfaces\Repositories\Routes\PostRouteRepositoryInterface;
use Tokenly\Wp\Interfaces\Repositories\Routes\TermRouteRepositoryInterface;
use Tokenly\Wp\Interfaces\Repositories\Routes\WebRouteRepositoryInterface;
use Invoker\InvokerInterface;

/**
 * Registers routers
 */
class RouteServiceProvider extends ServiceProvider implements RouteServiceProviderInterface {
	protected InvokerInterface $invoker;
	protected string $root_dir;

	public function __construct(
		string $namespace,
		string $logo,
		string $brand,
		string $root_dir,
		InvokerInterface $invoker,
		AdminRouterInterface $admin_router,
		ApiRouterInterface $api_router,
		WebRouterInterface $web_router,
		PostRouterInterface $post_router,
		TermRouterInterface $term_router,
		AdminRouteRepositoryInterface $admin_route_repository,
		ApiRouteRepositoryInterface $api_route_repository,
		PostRouteRepositoryInterface $post_route_repository,
		TermRouteRepositoryInterface $term_route_repository,
		WebRouteRepositoryInterface $web_route_repository
	) {
		$this->invoker = $invoker;
		$this->root_dir = $root_dir;
		$this->services = array(
			'admin' => array(
				'router'                 => $admin_router,
				'repository'             => $admin_route_repository,
				'data'                   => array(
					'namespace' => $namespace,
					'logo'      => $logo,
					'brand'     => $brand,
				),
			),
			'api'	=> array(
				'router'                 => $api_router,
				'repository'             => $api_route_repository,
				'data'                   => array(),
			),
			'post'	=> array(
				'router'                 => $post_router,
				'repository'             => $post_route_repository,
				'data'                   => array(
					'namespace' => $namespace,
				),
			),
			'term'  => array(
				'router'                 => $term_router,
				'repository'             => $term_route_repository,
				'data'                   => array(
					'namespace' => $namespace,
				),
			),
			'web'	=> array(
				'router'                 => $web_router,
				'repository'             => $web_route_repository,
				'data'                   => array(
					'namespace' => $namespace,
				),
			),
		);
	}

	/**
	 * @inheritDoc
	 */
	public function register(): void {
		foreach ( $this->services as $key => $route_definition ) {
			$data = $route_definition['data'];
			$routes = $this->invoker->call( include( "{$this->root_dir}/routes/{$key}.php" ), $data );
			if ( isset( $route_definition['repository'] ) ) {
				$repository = $route_definition['repository'];
				$repository->register( $routes );
			}
			if ( isset( $route_definition['router'] ) ) {
				$router = $route_definition['router'];
				$router->register();
			}
			$this->services[ $key ] = $router;
		}
	}
}
