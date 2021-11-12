<?php

namespace Tokenly\Wp\Factories\Collections;

use Tokenly\Wp\Interfaces\Factories\Collections\AddressCollectionFactoryInterface;
use Tokenly\Wp\Interfaces\Factories\Models\AddressFactoryInterface;
use Tokenly\Wp\Interfaces\Collections\BalanceCollectionInterface;
use Tokenly\Wp\Interfaces\Models\AddressInterface;
use Tokenly\Wp\Factories\Factory;

class AddressCollectionFactory extends Factory implements AddressCollectionFactoryInterface {
	protected $address_factory;

	public function __construct(
		$factory,
		AddressFactoryInterface $address_factory
	) {
		parent::__construct( $factory );
		$this->address_factory = $address_factory;
	}

	/**
	 * Creates a new collection
	 * @param array $params New collection data
	 * @return AddressCollectionInterface
	 */
	public function create( $data, $args = array() ) {
		$items = array_map( function( $item_data ) {
			if ( is_a( $item_data, AddressInterface::class ) === false ) {
				return $this->address_factory->create( $item_data );
			} else {
				return $item_data;
			}
		}, $data );
		$collection = $this->factory->create( array(
			'items' => $items,
		) );
		return $collection;
	}
}
