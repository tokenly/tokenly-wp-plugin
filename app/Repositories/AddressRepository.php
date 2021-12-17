<?php

namespace Tokenly\Wp\Repositories;

use Tokenly\TokenpassClient\TokenpassAPIInterface;
use Tokenly\Wp\Interfaces\Repositories\AddressRepositoryInterface;
use Tokenly\Wp\Interfaces\Factories\Models\AddressFactoryInterface;
use Tokenly\Wp\Interfaces\Factories\Collections\AddressCollectionFactoryInterface;
use Tokenly\Wp\Interfaces\Factories\Collections\BalanceCollectionFactoryInterface;
use Tokenly\Wp\Interfaces\Collections\AddressCollectionInterface;
use Tokenly\Wp\Interfaces\Factories\Models\QuantityFactoryInterface;

/**
 * Manages blockchain addresses
 */
class AddressRepository implements AddressRepositoryInterface {
	protected $client;
	protected $address_factory;
	protected $address_collection_factory;
	protected $balance_collection_factory;
	protected $quantity_factory;
	
	public function __construct(
		TokenpassAPIInterface $client,
		AddressFactoryInterface $address_factory,
		AddressCollectionFactoryInterface $address_collection_factory,
		BalanceCollectionFactoryInterface $balance_collection_factory,
		QuantityFactoryInterface $quantity_factory
	) {
		$this->client = $client;
		$this->address_collection_factory = $address_collection_factory;
		$this->address_factory = $address_factory;
		$this->balance_collection_factory = $balance_collection_factory;
		$this->quantity_factory = $quantity_factory;
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
		$username = $params['username'];
		$addresses = $this->client->getPublicAddresses( $username );
		foreach ( $addresses as &$address ) {
			$address = $this->remap_fields( $address );
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
		$address = $this->remap_fields( $address );
		$address = $this->address_factory->create( $address );
		return $address;
	}

	protected function remap_fields( array $address ) {
		if ( isset( $address['balances'] ) ) {
			foreach ( $address['balances'] as $key => &$balance ) {
				$balance['asset'] = $key;
				$balance['name'] = $key;
				$balance['quantity'] = $this->quantity_factory->create( array(
					'value_sat' => $balance['value'],
					'precision' => $balance['precision'],
				) );
				unset( $balance['value'] );
			}
			$address['balance'] = $address['balances'];
			unset( $address['balances'] );
			$address['balance'] = array_values( $address['balance'] );
			$address['balance'] = $this->balance_collection_factory->create( $address['balance'] );
		}
		return $address;
	}
}
