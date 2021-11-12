<?php

namespace Tokenly\Wp\Factories;

use Tokenly\Wp\Interfaces\Factories\AddressCollectionFactoryInterface;
use Tokenly\Wp\Interfaces\Collections\BalanceCollectionInterface;
use Tokenly\Wp\Factories\Factory;

class AddressCollectionFactory extends Factory implements AddressCollectionFactoryInterface {
	/**
	 * Creates a new address collection
	 * @param array $params New address collection data
	 * @return AddressCollectionInterface
	 */
	public function create( $addresses ) {
		$address_collection = $this->factory->create( array(
			'addresses' => $addresses,
		) );
		return $address_collection;
	}
}
