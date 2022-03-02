<?php

namespace Tokenly\Wp;

use Tokenly\Wp\Interfaces\Providers\AppServiceProviderInterface;
use Tokenly\Wp\Interfaces\Providers\ListingServiceProviderInterface;
use Tokenly\Wp\Interfaces\Providers\PostTypeServiceProviderInterface;
use Tokenly\Wp\Interfaces\Providers\RouteServiceProviderInterface;
use Tokenly\Wp\Interfaces\Providers\ShortcodeServiceProviderInterface;
use Tokenly\Wp\Interfaces\Providers\TaxonomyServiceProviderInterface;
use Psr\Container\ContainerInterface;

final class Bootstrap {
	private ContainerInterface $container;
	private array $providers;

	public function __construct() {
		$this->container = $this->build_container();
		$this->providers = $this->get_providers();
		$this->register_providers();
		$this->boot_providers();
	}

	/**
	 * Gets all providers
	 * @return array
	 */
	protected function get_providers(): array {
		$providers = array(
			AppServiceProviderInterface::class,
			ListingServiceProviderInterface::class,
			PostTypeServiceProviderInterface::class,
			RouteServiceProviderInterface::class,
			ShortcodeServiceProviderInterface::class,
			TaxonomyServiceProviderInterface::class,
		);
		foreach ( $providers as &$provider ) {
			$provider = $this->container->get( $provider );
		}
		return $providers;
	}

	/**
	 * Registers all providers
	 * @return void
	 */
	protected function register_providers(): void {
		foreach ( $this->providers as $provider ) {
			$provider->register();
		}
	}

	/**
	 * Boots all providers
	 * @return void
	 */
	protected function boot_providers(): void {
		foreach ( $this->providers as $provider ) {
			$provider->boot();
		}
	}

	/**
	 * Builds the container
	 * @return ContainerInterface
	 */
	protected function build_container(): ContainerInterface {
		$builder = new \DI\ContainerBuilder();
		$builder->addDefinitions( __DIR__ . './../config/phpdi.php' );
		$builder->useAnnotations( true );
		$container = $builder->build();
		return $container;
	}
}
