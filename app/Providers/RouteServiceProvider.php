<?php

namespace Tokenly\Wp\Providers;

use Tokenly\Wp\Providers\ServiceProvider;
use Tokenly\Wp\Interfaces\Providers\RouteServiceProviderInterface;
use Tokenly\Wp\Interfaces\Routes\AdminRouterInterface;
use Tokenly\Wp\Interfaces\Routes\ApiRouterInterface;
use Tokenly\Wp\Interfaces\Routes\PostTypeRouterInterface;
use Tokenly\Wp\Interfaces\Routes\TaxonomyRouterInterface;
use Tokenly\Wp\Interfaces\Routes\WebRouterInterface;

/**
 * Registers routers
 */
class RouteServiceProvider extends ServiceProvider implements RouteServiceProviderInterface{
	public function __construct(
		AdminRouterInterface $admin_router,
		ApiRouterInterface $api_router,
		WebRouterInterface $web_router,
		TaxonomyRouterInterface $taxonomy_router,
		PostTypeRouterInterface $post_type_router
	) {
		$this->services = array(
			'admin'    => $admin_router,
			'api'	   => $api_router,
			'post'	   => $post_type_router,
			'taxonomy' => $taxonomy_router,
			'web'	   => $web_router,
		);
	}
}
