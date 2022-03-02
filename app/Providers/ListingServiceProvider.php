<?php

namespace Tokenly\Wp\Providers;

use Tokenly\Wp\Providers\ServiceProvider;
use Tokenly\Wp\Interfaces\Providers\ListingServiceProviderInterface;

use Tokenly\Wp\Interfaces\Services\Application\Routers\Listings\PostRouterInterface;
use Tokenly\Wp\Interfaces\Services\Application\Routers\Listings\UserRouterInterface;
use Tokenly\Wp\Interfaces\Repositories\UserRepositoryInterface;
use Tokenly\Wp\Interfaces\Repositories\PostRepositoryInterface;
use Invoker\InvokerInterface;

/**
 * Registers columns
 */
class ListingServiceProvider extends ServiceProvider implements ListingServiceProviderInterface {
	protected InvokerInterface $invoker;
	protected string $root_dir;
	protected string $namespace;
	protected UserRepositoryInterface $user_repository;
	protected PostRepositoryInterface $post_repository;

	public function __construct(
		string $namespace,
		string $root_dir,
		InvokerInterface $invoker,
		PostRouterInterface $post_router,
		UserRouterInterface $user_router,
		UserRepositoryInterface $user_repository,
		PostRepositoryInterface $post_repository
	) {
		$this->user_repository = $user_repository;
		$this->post_repository = $post_repository;
		$this->invoker = $invoker;
		$this->root_dir = $root_dir;
		$this->namespace = $namespace;
		$this->services = array();
		global $pagenow;
		switch ( $pagenow ) {
			case 'edit.php':
				$this->services['post'] = array(
					'router' => $post_router,
					'data'   => array(
						'namespace' => $namespace,
					),
				);
				break;
			case 'users.php':
				$this->services['user'] = array(
					'router' => $user_router,
					'data'   => array(
						'namespace' => $namespace,
					),
				);
				break;
		}
	}

	/**
	 * @inheritDoc
	 */
	public function register(): void {
		foreach ( $this->services as $key => $router_definition ) {
			$data = $router_definition['data'];
			$routes = $this->invoker->call( include( "{$this->root_dir}/routes/listings/{$key}.php" ), $data );
			$router = $router_definition['router'];
			if ( isset( $routes['actions'] ) ) {
				$router->register_actions( $routes['actions'] );
			}
			if ( isset( $routes['columns'] ) ) {
				$columns = $routes['columns']() ?? array();
				$router->register_columns( $columns );
			}
			$this->services[ $key ] = $router;
		}
	}
}
