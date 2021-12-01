<?php

namespace Tokenly\Wp\Services\Domain;

use Tokenly\Wp\Services\Domain\DomainService;
use Tokenly\Wp\Interfaces\Services\Domain\OauthUserServiceInterface;
use Tokenly\Wp\Interfaces\Repositories\OauthUserRepositoryInterface;
use Tokenly\Wp\Interfaces\Repositories\General\UserMetaRepositoryInterface;
use Tokenly\Wp\Interfaces\Services\Domain\BalanceServiceInterface;
use Tokenly\Wp\Interfaces\Services\Domain\AddressServiceInterface;

/**
 * Manages the OAuth users
 */
class OauthUserService extends DomainService implements OauthUserServiceInterface {
	protected $oauth_user_cache = array();
	protected $oauth_user_repository;
	protected $user_meta_repository;
	protected $balance_service;
	protected $address_service;

	public function __construct(
		OauthUserRepositoryInterface $oauth_user_repository,
		UserMetaRepositoryInterface $user_meta_repository,
		BalanceServiceInterface $balance_service,
		AddressServiceInterface $address_service
	) {
		$this->oauth_user_repository = $oauth_user_repository;
		$this->user_meta_repository = $user_meta_repository;
		$this->balance_service = $balance_service;
		$this->address_service = $address_service;
	}
	
	public function show( array $params = array() ) {
		$oauth_token;
		if ( isset( $params['id'] ) ) {
			$user_id = $params['id'];
			$oauth_token = $this->user_meta_repository->show( $user_id, 'oauth_token' );
			if ( !$oauth_token ) {
				return;
			}
		}
		if ( isset( $params['oauth_token'] ) ) {
			$oauth_token = $params['oauth_token'];
		}
		$oauth_user;
		if ( isset( $this->user_cache[ $oauth_token ] ) ) {
			$oauth_user = $this->user_cache[ $oauth_token ];
		} else {
			$oauth_user = $this->oauth_user_repository->show( $oauth_token );
			$this->user_cache[ $oauth_token ] = $oauth_user;
		}
		if ( !$oauth_user ) {
			return;
		}
		return $oauth_user;
	}

	/**
	 * Gets all addresses
	 * @param OauthUserInterface Target user
	 * @param array $params Loading parameters
	 * @return OauthUserInterface
	 */
	public function load_addresses( OauthUserInterface $oauth_user, array $params = array() ) {
		$username = $oauth_user->username;
		$params['username'] = $username;
		$addresses = $this->address_service->index( $params );
		$oauth_user->addresses = $addresses;
		return $oauth_user;
	}

	/**
	 * Gets all balances
	 * @param OauthUserInterface $oauth_user Target user
	 * @param array $params Balance search parameters
	 * @return BalanceCollectionInterface Found balances
	 */
	public function load_balances( OauthUserInterface $oauth_user, array $params = array() ) {
		$balances = $this->balance_service->index( $oauth_user->oauth_token, $params );
		$oauth_user->balances = $balances;
		return $oauth_user;
	}
}
