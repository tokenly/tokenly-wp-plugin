<?php

namespace Tokenly\Wp\Providers;

use Tokenly\Wp\Providers\ServiceProvider;
use Tokenly\Wp\Interfaces\Providers\AppServiceProviderInterface;
use Tokenly\Wp\Interfaces\Services\AuthServiceInterface;
use Tokenly\Wp\Interfaces\Services\LifecycleServiceInterface;
use Tokenly\Wp\Interfaces\Services\ResourceServiceInterface;
use Tokenly\Wp\Interfaces\Services\Domain\UserServiceInterface;

/**
 * Registers general plugin modules
 */
class AppServiceProvider extends ServiceProvider implements AppServiceProviderInterface {
	protected $services;

	public function __construct(
		AuthServiceInterface $auth_service,
		LifecycleServiceInterface $lifecycle_service,
		ResourceServiceInterface $resource_service,
		UserServiceInterface $user_service
	) {
		$this->services = array(
			'auth'      => $auth_service,
			'lifecycle' => $lifecycle_service,
			'resource'  => $resource_service,
			'user'      => $user_service,
		);
	}

	/**
	 * Registers the services
	 * @return void
	 */
	public function register() {
		foreach ( $this->services as $service ) {
			$service->register();
		}
	}
}
