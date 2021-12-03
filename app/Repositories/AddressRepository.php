<?php

namespace Tokenly\Wp\Repositories;

use Tokenly\TokenpassClient\TokenpassAPIInterface;
use Tokenly\Wp\Interfaces\Repositories\AddressRepositoryInterface;
use Tokenly\Wp\Interfaces\Factories\Models\AddressFactoryInterface;
use Tokenly\Wp\Interfaces\Factories\Collections\AddressCollectionFactoryInterface;
use Tokenly\Wp\Interfaces\Collections\AddressCollectionInterface;

/**
 * Manages blockchain addresses
 */
class AddressRepository implements AddressRepositoryInterface {
	protected $client;
	protected $address_factory;
	protected $address_collection_factory;
	protected $address_cache = array();
	
	public function __construct(
		TokenpassAPIInterface $client,
		AddressFactoryInterface $address_factory,
		AddressCollectionFactoryInterface $address_collection_factory
	) {
		$this->client = $client;
		$this->address_collection_factory = $address_collection_factory;
		$this->address_factory = $address_factory;
	}

	/**
	 * Gets the list of public addresses for the username
	 * @param array $params Index params
	 * @return AddressCollectionInterface
	 */
	public function index( $params = array() ) {
		if ( !isset( $params['username'] ) ) {
			return false;
		}
		$username = $params['username'] ?? null;
		$addresses = $this->client->getPublicAddresses( $username );
		foreach ( $addresses as &$address ) {
			if ( isset( $address['balances'] ) ) {
				foreach ( $address['balances'] as $key => &$balance ) {
					$balance['asset'] = $key;
					$balance['name'] = $key;
					$balance['balanceSat'] = $balance['value'] ?? null;
				}
				$address['balances'] = array_values( $address['balances'] );
			}
		}
		$address_collection = $this->address_collection_factory->create( $addresses );
		return $address_collection;
	}

	/**
	 * Gets the list of public addresses for the username
	 * @param array $params Index params
	 * @return AddressCollectionInterface
	 */
	public function show( array $params = array() ) {
		if (
			!isset( $params['address'] ) ||
			!isset( $params['username'] )
		) {
			return;
		}
		$address = $this->client->getPublicAddressDetails( $params['username'], $params['address'] );
		if( !$address ){
			return;
		}
		$address = $this->address_factory->create( $address );
		return $address;
	}
}
