<?php

namespace Tokenly\Wp;

use Tokenly\Wp\Interfaces\Providers\AppServiceProviderInterface;
use Tokenly\Wp\Interfaces\Providers\RouteServiceProviderInterface;
use Tokenly\Wp\Interfaces\Providers\ShortcodeServiceProviderInterface;

final class Bootstrap {
	private $container;
	private $providers;

	public function __construct() {
		$this->container = $this->build_container();
		$this->register_providers();
	}

	protected function get_providers() {
		return array(
			AppServiceProviderInterface::class,
			RouteServiceProviderInterface::class,
			ShortcodeServiceProviderInterface::class
		);
	}

	protected function register_providers() {
		$this->providers = $this->get_providers();
		foreach ( $this->providers as $provider ) {
			$provider = $this->container->get( $provider );
			$provider->register();
		}
	}

	protected function build_container() {
		$builder = new \DI\ContainerBuilder();
		$builder->useAnnotations( true );
		$builder->addDefinitions( TOKENLY_PLUGIN_DIR . '/config/phpdi.php' );
		$container = $builder->build();
		return $container;
	}
}
