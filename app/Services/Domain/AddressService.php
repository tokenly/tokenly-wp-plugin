<?php

namespace Tokenly\Wp\Services\Domain;

use Tokenly\Wp\Services\Domain\DomainService;
use Tokenly\Wp\Interfaces\Services\Domain\AddressServiceInterface;
use Tokenly\Wp\Interfaces\Repositories\AddressRepositoryInterface;
use Tokenly\Wp\Interfaces\Collections\AddressCollectionInterface;
use Tokenly\Wp\Interfaces\Services\Domain\OauthUserServiceInterface;

/**
 * Manages the addresses
 */
class AddressService extends DomainService implements AddressServiceInterface {
	protected $address_cache = array();
	protected $address_repository;
	protected $oauth_user_service;

	public function __construct(
		AddressRepositoryInterface $address_repository,
		OauthUserService $oauth_user_service
	) {
		$this->address_repository = $address_repository;
		$this->oauth_user_service = $oauth_user_service;
	}

	/**
	 * Gets a collection of addresses
	 * @param array $params Search parameters
	 * @return AddressCollectionInterface
	 */
	public function index( array $params = array() ) {
		if ( !isset( $params['username'] ) ) {
			return;
		}
		$username = $params['username'] ?? null;
		$addresses = $this->address_repository->index( $params );
		if ( isset( $params['with'] ) ) {
			$addreses = $addresses->load( $params['with'] );
		}
		return $addresses;
	}

	public function show( array $params = array() ) {
		if ( !isset( $params['address'] ) ) {
			return;
		}
		$oauth_user = $this->oauth_user_service->show( array(
			'address' => $params['address'],
		) );
		if ( !$oauth_user ) {
			return;
		}
		$params['oauth_token'] = $oauth_user->get_oauth_token();
		$address = $this->address_repository->show( $params );
		return $address;
	}
}
