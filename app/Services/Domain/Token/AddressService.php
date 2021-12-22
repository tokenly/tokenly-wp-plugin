<?php

namespace Tokenly\Wp\Services\Domain\Token;

use Tokenly\Wp\Services\Domain\DomainService;
use Tokenly\Wp\Interfaces\Services\Domain\Token\AddressServiceInterface;

use Tokenly\Wp\Interfaces\Repositories\Token\AddressRepositoryInterface;
use Tokenly\Wp\Interfaces\Collections\Token\AddressCollectionInterface;
use Tokenly\Wp\Interfaces\Services\Domain\OauthUserServiceInterface;

/**
 * Manages the addresses
 */
class AddressService extends DomainService implements AddressServiceInterface {
	protected $address_repository;
	protected $oauth_user_service;

	public function __construct(
		AddressRepositoryInterface $address_repository,
		OauthUserServiceInterface $oauth_user_service
	) {
		$this->address_repository = $address_repository;
		$this->oauth_user_service = $oauth_user_service;
	}

	/**
	 * Gets a collection of addresses
	 * @param array $params Search parameters
	 * @return AddressCollectionInterface Addresses found
	 */
	public function index( array $params = array() ) {
		return $this->handle_method( __FUNCTION__, func_get_args() );
	}

	/**
	 * Gets a single address
	 * @param array $params Search parameters
	 * @return AddressInterface Address found
	 */
	public function show( array $params = array() ) {
		return $this->handle_method( __FUNCTION__, func_get_args() );
	}

	/**
	 * Implementation of the "index" method. Will only
	 * run if no cached instance was found.
	 * @param array $params Search parameters
	 * @return AddressCollectionInterface Addresses found
	 */
	protected function index_cacheable( array $params = array() ) {
		if ( !isset( $params['username'] ) ) {
			return;
		}
		$address = $this->address_repository->index( $params );
		return $address;
	}

	/**
	 * Implementation of the "show" method. Will only
	 * run if no cached instance was found.
	 * @param array $params Search parameters
	 * @return AddressInterface Address found
	 */
	protected function show_cacheable( array $params = array() ) {
		if ( !isset( $params['address'] ) ) {
			return;
		}
		$oauth_user = $this->oauth_user_service->show( array(
			'address' => $params['address'],
		) );
		if ( !$oauth_user ) {
			return;
		}
		$params['username'] = $oauth_user->username;
		$address = $this->address_repository->show( $params );
		return $address;
	}
}
