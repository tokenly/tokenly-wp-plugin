<?php

namespace Tokenly\Wp\Providers;

use Tokenly\Wp\Interfaces\Providers\ServiceProviderInterface;

use Tokenly\Wp\Interfaces\Services\ServiceInterface;

class ServiceProvider implements ServiceProviderInterface {
	protected array $services = array();

	/**
	 * Registers the services
	 * @return void
	 */
	public function register(): void {
		foreach ( $this->services as $service ) {
			$service->register();
		}
	}

	/**
	 * Boots the services
	 * @return void
	 */
	public function boot(): void {
		foreach ( $this->services as $service ) {
			if ( $service instanceof ServiceInterface === false ) {
				continue;
			}
			$service->boot();
		}
	}
}
