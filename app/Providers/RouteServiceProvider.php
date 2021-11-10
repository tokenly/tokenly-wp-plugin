<?php

namespace Tokenly\Wp\Providers;

use Tokenly\Wp\Providers\ServiceProvider;
use Tokenly\Wp\Interfaces\Providers\RouteServiceProviderInterface;
use Tokenly\Wp\Interfaces\Routes\AdminRouterInterface;
use Tokenly\Wp\Interfaces\Routes\ApiRouterInterface;
use Tokenly\Wp\Interfaces\Routes\WebRouterInterface;
use Tokenly\Wp\Interfaces\Routes\PostTypeRouterInterface;

/**
 * Registers routers
 */
class RouteServiceProvider extends ServiceProvider implements RouteServiceProviderInterface{
	protected $routers;

	public function __construct(
		AdminRouterInterface $admin_router,
		ApiRouterInterface $api_router,
		WebRouterInterface $web_router,
		PostTypeRouterInterface $post_type_router
	) {
		$this->routers = array(
			'admin' => $admin_router,
			'api'	=> $api_router,
			'web'	=> $web_router,
			'post'	=> $post_type_router,
		);
	}

	/**
	 * Registers the service provider
	 * @return void
	 */
	public function register() {
		add_action( 'init', array( $this, 'register_routers' ) );
	}

	/**
	 * Registers all routers
	 * @wp-hook init
	 * @return void
	 */
	public function register_routers() {
		foreach ( $this->routers as $router ) {
			$router->register();
		}
	}
}
