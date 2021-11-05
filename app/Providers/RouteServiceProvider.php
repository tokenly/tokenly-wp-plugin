<?php

namespace Tokenly\Wp\Providers;

use Tokenly\Wp\Providers\ServiceProvider;
use Tokenly\Wp\Interfaces\Providers\RouteServiceProviderInterface;
use Tokenly\Wp\Interfaces\Routes\AdminRouterInterface;
use Tokenly\Wp\Interfaces\Routes\ApiRouterInterface;
use Tokenly\Wp\Interfaces\Routes\WebRouterInterface;
use Tokenly\Wp\Interfaces\Routes\PostTypeRouterInterface;

class RouteServiceProvider extends ServiceProvider implements RouteServiceProviderInterface{
	public $routers;

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
	public function register() {
		add_action( 'init', array( $this, 'register_routers' ) );
	}

	public function register_routers() {
		foreach ( $this->routers as $router ) {
			$router->register();
		}
	}
}
