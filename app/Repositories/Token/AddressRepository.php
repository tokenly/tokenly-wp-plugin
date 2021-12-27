<?php

namespace Tokenly\Wp\Repositories\Token;

use Tokenly\TokenpassClient\TokenpassAPIInterface;
use Tokenly\Wp\Interfaces\Repositories\Token\AddressRepositoryInterface;
use Tokenly\Wp\Interfaces\Factories\Models\Token\AddressFactoryInterface;
use Tokenly\Wp\Interfaces\Factories\Collections\Token\AddressCollectionFactoryInterface;
use Tokenly\Wp\Interfaces\Factories\Collections\Token\BalanceCollectionFactoryInterface;
use Tokenly\Wp\Interfaces\Collections\Token\AddressCollectionInterface;
use Tokenly\Wp\Interfaces\Factories\Models\Token\QuantityFactoryInterface;

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
	 * Gets a collection of addresses
	 * @param array $params Search parameters
	 * @return AddressCollectionInterface Addresses found
	 */
	public function index( $params = array() ) {
		$addresses = array();
		if ( isset( $params['username'] ) ) {
			$username = $params['username'];
			$addresses = $this->client->getPublicAddresses( $username );
			if ( $addresses & is_array( $addresses ) ) {
				foreach ( $addresses as &$address ) {
					$address = $this->remap_fields( $address );
				}
			}
		}
		$addresses = $this->address_collection_factory->create( $addresses );
		return $addresses;
	}

	/**
	 * Gets a single address
	 * @param array $params Search parameters
	 * @return AddressCollectionInterface Address found
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

	/**
	 * Formats the received item
	 * @param array $address Address received
	 * @return array $address Formatted address
	 */
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
