<?php

namespace Tokenly\Wp\Providers;

use Tokenly\Wp\Interfaces\Providers\ServiceProviderInterface;

class ServiceProvider implements ServiceProviderInterface {
	protected $services;

	/**
	 * Registers the services
	 * @return void
	 */
	public function register() {
		foreach ( $this->services as $service ) {
			$service->register();
		}
	}

	/**
	 * Boots the services
	 * @return void
	 */
	public function boot() {
		foreach ( $this->services as $service ) {
			$service->boot();
		}
	}
}
