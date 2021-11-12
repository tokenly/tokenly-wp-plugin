<?php

namespace Tokenly\Wp\Factories;

use Tokenly\Wp\Interfaces\Factories\AddressFactoryInterface;
use Tokenly\Wp\Interfaces\Models\AddressInterface;
use Tokenly\Wp\Factories\Factory;

class AddressFactory extends Factory implements AddressFactoryInterface {
	/**
	 * Creates a new address object
	 * @param array $params New address data
	 * @return AddressInterface
	 */
	public function create( $params ) {
		$address = $this->factory->create( array(
			'address_data' => array(
				'address'   => $params['address'] ?? '',
				'type'      => $params['type'] ?? 'unknown',
				'balances'  => $params['balances'] ?? array(),
				'label'     => $params['label'] ?? $params['address'],
			),
		) );
		return $address;
	}
}
