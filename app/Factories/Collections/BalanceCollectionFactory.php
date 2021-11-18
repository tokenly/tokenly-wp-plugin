<?php

namespace Tokenly\Wp\Factories\Collections;

use Tokenly\Wp\Interfaces\Factories\Collections\BalanceCollectionFactoryInterface;
use Tokenly\Wp\Interfaces\Factories\Models\BalanceFactoryInterface;
use Tokenly\Wp\Interfaces\Collections\BalanceCollectionInterface;
use Tokenly\Wp\Interfaces\Models\BalanceInterface;
use Tokenly\Wp\Factories\Factory;

class BalanceCollectionFactory extends Factory implements BalanceCollectionFactoryInterface {
	protected $balance_factory;

	public function __construct(
		$factory,
		BalanceFactoryInterface $balance_factory
	) {
		parent::__construct( $factory );
		$this->balance_factory = $balance_factory;
	}
	/**
	 * Creates a new collection
	 * @param array $params New collection data
	 * @return BalanceCollectionInterface
	 */
	public function create( $data, $args = array() ) {
		$items = array_map( function( $item_data ) {
			if ( is_a( $item_data, BalanceInterface::class ) === false ) {
				return $this->balance_factory->create( $item_data );
			} else {
				return $item_data;
			}
		}, $data );
		$collection = $this->factory->create( array(
			'items' => $items,
		) );
		if ( $args['use_whitelist'] ?? true == true ) {
			$collection->apply_whitelist();
		}
		return $collection;
	}
}
