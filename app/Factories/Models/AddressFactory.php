<?php

namespace Tokenly\Wp\Factories\Models;

use Tokenly\Wp\Interfaces\Factories\Models\AddressFactoryInterface;
use Tokenly\Wp\Interfaces\Factories\Collections\BalanceCollectionFactoryInterface;
use Tokenly\Wp\Interfaces\Models\AddressInterface;
use Tokenly\Wp\Factories\Factory;

class AddressFactory extends Factory implements AddressFactoryInterface {
	protected $balance_collection_factory;

	public function __construct(
		$factory,
		BalanceCollectionFactoryInterface $balance_collection_factory
	) {
		parent::__construct( $factory );
		$this->balance_collection_factory = $balance_collection_factory;
	}

	/**
	 * Creates a new address object
	 * @param array $data New address data
	 * @return AddressInterface
	 */
	public function create( $data, $args = array() ) {
		$balances = array();
		if ( isset( $data['balances'] ) ) {
			$balances = $data['balances'];
		}
		$balances = $this->balance_collection_factory->create( $balances );
		$address = $this->factory->create( array(
			'address'   => $data['address'] ?? '',
			'type'      => $data['type'] ?? 'unknown',
			'label'     => $data['label'] ?? $params['address'],
			'balances'  => $balances,
		) );
		return $address;
	}
}
