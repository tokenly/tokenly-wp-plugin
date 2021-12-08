<?php

namespace Tokenly\Wp\Services;

use Tokenly\Wp\Interfaces\Services\ServiceInterface;

/**
 * Provides the base functions for the other services
 */
class Service implements ServiceInterface {
	/**
	 * Registers the service
	 */
	public function register() {
		//
	}

	/**
	 * Called when all services are registered
	 */
	public function boot() {
		//
	}
}
