<?php

namespace Tokenly\Wp;

use Tokenly\Wp\Providers\AppServiceProvider;
use Tokenly\Wp\Providers\RouteServiceProvider;
use Tokenly\Wp\Providers\ShortcodeServiceProvider;


class Bootstrap {
	private $container;
	private $providers;

	public function __construct() {
		$this->container = $this->build_container();
		$this->register_providers();
	}

	public function get_providers() {
		return array(
			AppServiceProvider::class,
			RouteServiceProvider::class,
			ShortcodeServiceProvider::class
		);
	}

	public function register_providers() {
		$this->providers = $this->get_providers();
		foreach ( $this->providers as $provider ) {
			$provider = $this->container->get( $provider );
			$provider->register();
		}
	}

	public function build_container() {
		$builder = new \DI\ContainerBuilder();
		$builder->useAnnotations( true );
		$builder->addDefinitions( TOKENLY_PLUGIN_DIR . '/config/phpdi.php' );
		$container = $builder->build();
		return $container;
	}
}
