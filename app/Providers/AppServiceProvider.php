<?php

namespace Tokenly\Wp\Providers;

use Tokenly\Wp\Providers\ServiceProvider;
use Tokenly\Wp\Interfaces\Providers\AppServiceProviderInterface;
use Tokenly\Wp\Interfaces\Services\AuthServiceInterface;
use Tokenly\Wp\Interfaces\Services\LifecycleServiceInterface;
use Tokenly\Wp\Interfaces\Services\ResourceServiceInterface;
use Tokenly\Wp\Interfaces\Services\TcaServiceInterface;
use Tokenly\Wp\Interfaces\Services\Domain\AddressServiceInterface;
use Tokenly\Wp\Interfaces\Services\Domain\BalanceServiceInterface;
use Tokenly\Wp\Interfaces\Services\Domain\IntegrationServiceInterface;
use Tokenly\Wp\Interfaces\Services\Domain\IntegrationSettingsServiceInterface;
use Tokenly\Wp\Interfaces\Services\Domain\OauthUserServiceInterface;
use Tokenly\Wp\Interfaces\Services\Domain\PostServiceInterface;
use Tokenly\Wp\Interfaces\Services\Domain\PromiseMetaServiceInterface;
use Tokenly\Wp\Interfaces\Services\Domain\PromiseServiceInterface;
use Tokenly\Wp\Interfaces\Services\Domain\SourceServiceInterface;
use Tokenly\Wp\Interfaces\Services\Domain\TcaSettingsServiceInterface;
use Tokenly\Wp\Interfaces\Services\Domain\TokenMetaServiceInterface;
use Tokenly\Wp\Interfaces\Services\Domain\UserServiceInterface;
use Tokenly\Wp\Interfaces\Services\Domain\WhitelistServiceInterface;

/**
 * Registers general plugin modules
 */
class AppServiceProvider extends ServiceProvider implements AppServiceProviderInterface {
	protected $services;

	public function __construct(
		AuthServiceInterface $auth_service,
		LifecycleServiceInterface $lifecycle_service,
		ResourceServiceInterface $resource_service,
		TcaServiceInterface $tca_service,
		AddressServiceInterface $address_service,
		BalanceServiceInterface $balance_service,
		IntegrationServiceInterface $integration_service,
		IntegrationSettingsServiceInterface $integration_settings_service,
		OauthUserServiceInterface $oauth_user_service,
		PostServiceInterface $post_service,
		PromiseMetaServiceInterface $promise_meta_service,
		PromiseServiceInterface $promise_service,
		SourceServiceInterface $source_service,
		TcaSettingsServiceInterface $tca_settings_service,
		TokenMetaServiceInterface $token_meta_service,
		UserServiceInterface $user_service,
		WhitelistServiceInterface $whitelist_service
	) {
		$this->services = array(
			'auth'                  => $auth_service,
			'lifecycle'             => $lifecycle_service,
			'resource'              => $resource_service,
			'tca'                   => $tca_service,
			'address'               => $address_service,
			'balance'               => $balance_service,
			'integration'           => $integration_service,
			'integration_settings'  => $integration_settings_service,
			'oauth_user'            => $oauth_user_service,
			'post'                  => $post_service,
			'promise_meta'          => $promise_meta_service,
			'promise'               => $promise_service,
			'source'                => $source_service,
			'tca_settings'          => $tca_settings_service,
			'token_meta'            => $token_meta_service,
			'user'                  => $user_service,
			'whitelist'             => $whitelist_service
		);
	}
}
