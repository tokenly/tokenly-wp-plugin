<?php

namespace Tokenly\Wp\Providers;

use Tokenly\Wp\Providers\ServiceProvider;
use Tokenly\Wp\Interfaces\Providers\AppServiceProviderInterface;
use Tokenly\Wp\Interfaces\Services\AuthServiceInterface;
use Tokenly\Wp\Interfaces\Services\LifecycleServiceInterface;
use Tokenly\Wp\Interfaces\Services\ResourceServiceInterface;
use Tokenly\Wp\Interfaces\Services\TcaServiceInterface;
use Tokenly\Wp\Interfaces\Services\QueryServiceInterface;
use Tokenly\Wp\Interfaces\Services\Domain\AddressServiceInterface;
use Tokenly\Wp\Interfaces\Services\Domain\BalanceServiceInterface;
use Tokenly\Wp\Interfaces\Services\Domain\CreditGroupServiceInterface;
use Tokenly\Wp\Interfaces\Services\Domain\CreditTransactionServiceInterface;
use Tokenly\Wp\Interfaces\Services\Domain\OauthUserServiceInterface;
use Tokenly\Wp\Interfaces\Services\Domain\PostServiceInterface;
use Tokenly\Wp\Interfaces\Services\Domain\PromiseMetaServiceInterface;
use Tokenly\Wp\Interfaces\Services\Domain\PromiseServiceInterface;
use Tokenly\Wp\Interfaces\Services\Domain\SourceServiceInterface;
use Tokenly\Wp\Interfaces\Services\Domain\TokenMetaServiceInterface;
use Tokenly\Wp\Interfaces\Services\Domain\UserServiceInterface;

/**
 * Registers general plugin modules
 */
class AppServiceProvider extends ServiceProvider implements AppServiceProviderInterface {
	protected $services;

	public function __construct(
		//Application
		AuthServiceInterface $auth_service,
		LifecycleServiceInterface $lifecycle_service,
		ResourceServiceInterface $resource_service,
		TcaServiceInterface $tca_service,
		QueryServiceInterface $query_service,
		//Domain
		AddressServiceInterface $address_service,
		BalanceServiceInterface $balance_service,
		CreditGroupServiceInterface $credit_group_service,
		CreditTransactionServiceInterface $credit_transaction_service,
		OauthUserServiceInterface $oauth_user_service,
		PostServiceInterface $post_service,
		PromiseMetaServiceInterface $promise_meta_service,
		PromiseServiceInterface $promise_service,
		SourceServiceInterface $source_service,
		TokenMetaServiceInterface $token_meta_service,
		UserServiceInterface $user_service
	) {
		$this->services = array(
			//Application
			'auth'                  => $auth_service,
			'lifecycle'             => $lifecycle_service,
			'resource'              => $resource_service,
			'tca'                   => $tca_service,
			'query'                 => $query_service,
			//Domain
			'address'               => $address_service,
			'balance'               => $balance_service,
			'credit-group'          => $credit_group_service,
			'credit-transaction'    => $credit_transaction_service,
			'oauth_user'            => $oauth_user_service,
			'post'                  => $post_service,
			'promise_meta'          => $promise_meta_service,
			'promise'               => $promise_service,
			'source'                => $source_service,
			'token_meta'            => $token_meta_service,
			'user'                  => $user_service,
		);
	}
}
