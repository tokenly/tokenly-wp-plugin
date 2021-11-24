<?php

namespace Tokenly\Wp\Services\Domain;

use Tokenly\Wp\Interfaces\Services\Domain\AddressServiceInterface;
use Tokenly\Wp\Interfaces\Services\Domain\BalanceServiceInterface;
use Tokenly\Wp\Interfaces\Repositories\AddressRepositoryInterface;

class AddressService implements AddressServiceInterface {
	protected $address_cache = array();
	protected $address_repository;
	protected $balance_service;

	public function __construct(
		AddressRepositoryInterface $address_repository,
		BalanceServiceInterface $balance_service
	) {
		$this->address_repository = $address_repository;
		$this->balance_service = $balance_service;
	}

	public function index( array $params = array() ) {
		if ( !isset( $params['username'] ) ) {
			return;
		}
		$username = $params['username'] ?? null;
		$addresses;
		if ( isset( $this->address_cache[ $username ] ) ) {
			$addresses = $this->address_cache[ $username ];
		} else {
			$addresses = $this->address_repository->index( $params );
			$this->address_cache[ $username ] = $addresses;
		}
		if ( isset( $params['with'] ) ) {
			$addresses = $this->handle_with( $addresses, $params['with'] );
		}
		return $addresses;
	}

	/**
	 * Handles queries using parameter 'with'
	 * @param AddressCollectionInterface $addresses Queried addresses
	 * @return AddressCollectionInterface Modified addresses
	 */
	protected function handle_with( AddressCollectionInterface $addresses, array $with ) {
		if ( in_array( 'balances.meta', $with ) ) {
			$addresses = $this->handle_with_balances_meta( $addresses );
		}
		return $addresses;
	}

	/**
	 * Appends Address objects to the queries addresses (part of 'with' handler)
	 * @param AddressCollectionInterface $addresses Queried addresses
	 * @return AddressCollectionInterface Modified addresses
	 */
	protected function handle_with_balances_meta( AddressCollectionInterface $addresses ) {
		foreach( (array) $addresses as &$address ) {
			$address->balances = $this->balance_service->handle_with_meta( $address->balances );
		}
		return $addresses;
	}
}
