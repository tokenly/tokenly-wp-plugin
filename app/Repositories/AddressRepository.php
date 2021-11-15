<?php

namespace Tokenly\Wp\Repositories;

use Tokenly\TokenpassClient\TokenpassAPIInterface;
use Tokenly\Wp\Interfaces\Repositories\AddressRepositoryInterface;
use Tokenly\Wp\Interfaces\Factories\Collections\AddressCollectionFactoryInterface;
use Tokenly\Wp\Interfaces\Collections\AddressCollectionInterface;
use Tokenly\Wp\Interfaces\Repositories\BalanceRepositoryInterface;

/**
 * Manages blockchain addresses
 */
class AddressRepository implements AddressRepositoryInterface {
	protected $client;
	protected $address_collection_factory;
	protected $balance_repository;
	
	public function __construct(
		TokenpassAPIInterface $client,
		AddressCollectionFactoryInterface $address_collection_factory,
		BalanceRepositoryInterface $balance_repository
	) {
		$this->client = $client;
		$this->address_collection_factory = $address_collection_factory;
		$this->balance_repository = $balance_repository;
	}

	/**
	 * Gets the list of public addresses for the username
	 * @param array $params Index params
	 * @return AddressCollectionInterface
	 */
	public function index( $params = array() ) {
		$username = $params['username'] ?? null;
		if ( !$username ) {
			return;
		}
		$addresses = $this->client->getPublicAddresses( $username );
		$addresses = array_map( function( $address ) {
			$address['balances'] = array_map( function( $key, $balance ) {
				$balance['asset'] = $key;
				$balance['name'] = $key;
				$balance['balanceSat'] = $balance['value'] ?? null;
				return $balance;
			}, array_keys( $address['balances'] ), $address['balances'] );
			return $address;
		}, $addresses );
		$address_collection = $this->address_collection_factory->create( $addresses );
		if ( isset( $params['with'] ) ) {
			$address_collection = $this->handle_with( $address_collection, $params['with'] );
		}
		return $address_collection;
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
			$address->balances = $this->balance_repository->handle_with_meta( $address->balances );
		}
		return $addresses;
	}
}
