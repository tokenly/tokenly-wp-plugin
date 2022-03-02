<?php

namespace Tokenly\Wp\Services;

use Tokenly\Wp\Interfaces\Services\ServiceInterface;

/**
 * Provides the base functions for the other services
 */
class Service implements ServiceInterface {
	/**
	 * Registers the service
	 * @return void
	 */
	public function register(): void {
		//
	}

	/**
	 * Called when all services are registered
	 * @return void
	 */
	public function boot(): void {
		//
	}
}
