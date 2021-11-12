<?php

namespace Tokenly\Wp\Repositories;

use Tokenly\TokenpassClient\TokenpassAPIInterface;
use Tokenly\Wp\Interfaces\Repositories\AddressRepositoryInterface;
use Tokenly\Wp\Interfaces\Factories\Collections\AddressCollectionFactoryInterface;
use Tokenly\Wp\Interfaces\Collections\AddressCollectionInterface;

/**
 * Manages blockchain addresses
 */
class AddressRepository implements AddressRepositoryInterface {
	protected $client;
	protected $address_collection_factory;
	
	public function __construct(
		TokenpassAPIInterface $client,
		AddressCollectionFactoryInterface $address_collection_factory
	) {
		$this->client = $client;
		$this->address_collection_factory = $address_collection_factory;
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
		return $address_collection;
	}
}
