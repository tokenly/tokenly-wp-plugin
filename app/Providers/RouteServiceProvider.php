<?php

namespace Tokenly\Wp\Providers;

use Tokenly\Wp\Routes\AdminRouter;
use Tokenly\Wp\Routes\ApiRouter;
use Tokenly\Wp\Routes\WebRouter;

class RouteServiceProvider {
	public $routers;

	public function __construct(
		AdminRouter $admin_router,
		ApiRouter $api_router,
		WebRouter $web_router
	) {
		$this->routers = array(
			'admin' => $admin_router,
			'api'	=> $api_router,
			'web'	=> $web_router,
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
