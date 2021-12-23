<?php

namespace Tokenly\Wp\Providers;

use Tokenly\Wp\Providers\ServiceProvider;
use Tokenly\Wp\Interfaces\Providers\AppServiceProviderInterface;
use Tokenly\Wp\Interfaces\Services\AuthServiceInterface;
use Tokenly\Wp\Interfaces\Services\LifecycleServiceInterface;
use Tokenly\Wp\Interfaces\Services\ResourceServiceInterface;
use Tokenly\Wp\Interfaces\Services\QueryServiceInterface;
use Tokenly\Wp\Interfaces\Services\Domain\OauthUserServiceInterface;
use Tokenly\Wp\Interfaces\Services\Domain\PostServiceInterface;
use Tokenly\Wp\Interfaces\Services\Domain\UserServiceInterface;
use Tokenly\Wp\Interfaces\Services\Domain\Credit\GroupServiceInterface as CreditGroupServiceInterface;
use Tokenly\Wp\Interfaces\Services\Domain\Credit\TransactionServiceInterface as CreditTransactionServiceInterface;
use Tokenly\Wp\Interfaces\Services\Domain\Token\AddressServiceInterface as TokenAddressServiceInterface;
use Tokenly\Wp\Interfaces\Services\Domain\Token\BalanceServiceInterface as TokenBalanceServiceInterface;
use Tokenly\Wp\Interfaces\Services\Domain\Token\PromiseMetaServiceInterface as TokenPromiseMetaServiceInterface;
use Tokenly\Wp\Interfaces\Services\Domain\Token\PromiseServiceInterface as TokenPromiseServiceInterface;
use Tokenly\Wp\Interfaces\Services\Domain\Token\SourceServiceInterface as TokenSourceServiceInterface;
use Tokenly\Wp\Interfaces\Services\Domain\Token\MetaServiceInterface as TokenMetaServiceInterface;

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
		QueryServiceInterface $query_service,
		//Domain
		CreditGroupServiceInterface $credit_group_service,
		CreditTransactionServiceInterface $credit_transaction_service,
		OauthUserServiceInterface $oauth_user_service,
		PostServiceInterface $post_service,
		TokenAddressServiceInterface $token_address_service,
		TokenBalanceServiceInterface $token_balance_service,
		TokenPromiseMetaServiceInterface $token_promise_meta_service,
		TokenPromiseServiceInterface $token_promise_service,
		TokenSourceServiceInterface $token_source_service,
		TokenMetaServiceInterface $token_meta_service,
		UserServiceInterface $user_service
	) {
		$this->services = array(
			//Application
			'auth'                  => $auth_service,
			'lifecycle'             => $lifecycle_service,
			'resource'              => $resource_service,
			'query'                 => $query_service,
			//Domain
			'credit_group'          => $credit_group_service,
			'credit_transaction'    => $credit_transaction_service,
			'oauth_user'            => $oauth_user_service,
			'post'                  => $post_service,
			'token_address'         => $token_address_service,
			'token_balance'         => $token_balance_service,
			'token_promise_meta'    => $token_promise_meta_service,
			'token_promise'         => $token_promise_service,
			'token_source'          => $token_source_service,
			'token_meta'            => $token_meta_service,
			'user'                  => $user_service,
		);
	}
}
