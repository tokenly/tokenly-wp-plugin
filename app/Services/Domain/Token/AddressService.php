<?php

namespace Tokenly\Wp\Services\Domain\Token;

use Tokenly\Wp\Services\Domain\DomainService;
use Tokenly\Wp\Interfaces\Services\Domain\Token\AddressServiceInterface;

use Tokenly\Wp\Interfaces\Repositories\Token\AddressRepositoryInterface;
use Tokenly\Wp\Interfaces\Collections\Token\AddressCollectionInterface;
use Tokenly\Wp\Interfaces\Services\Domain\OauthUserServiceInterface;
use Tokenly\Wp\Interfaces\Services\Domain\UserServiceInterface;
use Tokenly\Wp\Interfaces\Models\OauthUserInterface;
use Tokenly\Wp\Interfaces\Models\UserInterface;

/**
 * Manages the addresses
 */
class AddressService extends DomainService implements AddressServiceInterface {
	protected $address_repository;
	protected $user_service;
	protected $current_user;
	protected $oauth_user_service;

	public function __construct(
		AddressRepositoryInterface $address_repository,
		UserServiceInterface $user_service,
		OauthUserServiceInterface $oauth_user_service
	) {
		$this->address_repository = $address_repository;
		$this->user_service = $user_service;
		$this->current_user = $this->user_service->show_current();
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
		if ( isset( $params['id'] ) && $params['id'] == 'me' ) {
			if ( $this->current_user && $this->current_user instanceof UserInterface ) {
				$this->current_user->load( array( 'oauth_user' ) );
				if (
					isset($this->current_user->oauth_user ) &&
					$this->current_user->oauth_user instanceof OauthUserInterface
				) {
					$params['username'] = $this->current_user->oauth_user->username;
				}
			}
		}
		if ( !isset( $params['username'] ) ) {
			return;
		}
		$address = $this->address_repository->index( $params );
		if ( !$address ) {
			return;
		}
		if ( isset( $params['registered'] ) && $params['registered'] == true ) {
			$address->filter_registered();
			$address->key_by_field( 'address' );
		}
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
