<?php

/**
 * Collection of Address objects
 */

namespace Tokenly\Wp\Collections;

use Tokenly\Wp\Interfaces\Collections\AddressCollectionInterface;
use Tokenly\Wp\Interfaces\Models\AddressInterface;
use Tokenly\Wp\Interfaces\Factories\AddressFactoryInterface;

class AddressCollection extends \ArrayObject implements AddressCollectionInterface {
	protected $address_factory;

	public function __construct(
		array $addresses,
		AddressFactoryInterface $address_factory
	) {
		$this->address_factory = $address_factory;
		$this->from_array( $addresses );
	}

	protected function from_array( array $addresses ) {
		$addresses = array_map( function( $address_data ) {
			if ( is_a( $address_data, AddressInterface::class ) === false ) {
				return $this->address_factory->create( $address_data );
			} else {
				return $address_data;
			}
		}, $addresses );
		$this->exchangeArray( $addresses );
	}

	public function to_array() {
		$array = array_map( function( $address ) {
			return $address->to_array();
		}, ( array ) $this );
		return $array;
	}
}
