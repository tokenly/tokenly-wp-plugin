<?php

namespace Tokenly\Wp;

use Tokenly\Wp\Providers\AppServiceProvider;
use Tokenly\Wp\Providers\RouteServiceProvider;
use Tokenly\Wp\Providers\ShortcodeServiceProvider;

use Twig\Environment;
use Twig\Loader\FilesystemLoader;

class Bootstrap {
	public function get_providers() {
		return array(
			AppServiceProvider::class,
			RouteServiceProvider::class,
		);
	}

	public function boot() {
		$builder = new \DI\ContainerBuilder();
		$builder->useAnnotations( true );
		$builder->addDefinitions([
			Environment::class => function () {
				$loader = new FilesystemLoader( TOKENLY_PLUGIN_TEMPLATE_DIR );
				$twig = new Environment( $loader, array(
					'cache' => TOKENLY_PLUGIN_TEMPLATE_CACHE_DIR,
				) );
				return $twig;
			},
		]);
		$container = $builder->build();
		$providers = $this->get_providers();
		foreach ( $providers as $provider ) {
			$provider = new $provider();
			$provider->boot();
		}
		$shortcode_service_provider = $container->get( 'Tokenly\Wp\Providers\ShortcodeServiceProvider' );
		$shortcode_service_provider->boot(
			$container->get( 'Tokenly\Wp\Shortcodes\LoginButtonShortcode' )
		);
	}
}
