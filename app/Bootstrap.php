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
		$this->providers = $this->get_providers();
		$this->register_providers();
		$this->boot_providers();
	}

	protected function get_providers() {
		$providers = array(
			AppServiceProviderInterface::class,
			RouteServiceProviderInterface::class,
			ShortcodeServiceProviderInterface::class
		);
		foreach ( $providers as &$provider ) {
			$provider = $this->container->get( $provider );
		}
		return $providers;
	}

	protected function register_providers() {
		foreach ( $this->providers as $provider ) {
			$provider->register();
		}
	}

	protected function boot_providers() {
		foreach ( $this->providers as $provider ) {
			$provider->boot();
		}
	}

	protected function build_container() {
		$builder = new \DI\ContainerBuilder();
		$builder->addDefinitions( __DIR__ . './../config/phpdi.php' );
		$container = $builder->build();
		return $container;
	}
}
