<?php

namespace Tokenly\Wp\Providers;

use Tokenly\Wp\Routes\AdminRouter;
use Tokenly\Wp\Routes\ApiRouter;
use Tokenly\Wp\Routes\WebRouter;

class RouteServiceProvider {
	public function boot() {
		add_action( 'init', array( $this, 'register_routers' ) );
	}

	public function get_routers() {
		return array(
			AdminRouter::class,
			ApiRouter::class,
			WebRouter::class,
		);
	}

	public function register_routers() {
		$routers = $this->get_routers();
		foreach ( $routers as $router ) {
			$router = new $router();
			$router->boot();
		}
	}
}
