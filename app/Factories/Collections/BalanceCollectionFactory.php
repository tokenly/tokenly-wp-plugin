<?php

namespace Tokenly\Wp\Factories\Collections;

use Tokenly\Wp\Factories\Collections\CollectionFactory;
use Tokenly\Wp\Interfaces\Factories\Collections\BalanceCollectionFactoryInterface;
use Tokenly\Wp\Interfaces\Factories\Models\BalanceFactoryInterface;
use Tokenly\Wp\Interfaces\Collections\BalanceCollectionInterface;

class BalanceCollectionFactory extends CollectionFactory implements BalanceCollectionFactoryInterface {
	public function __construct(
		$factory,
		BalanceFactoryInterface $item_factory
	) {
		parent::__construct( $factory, $item_factory );
	}
	/**
	 * Creates a new collection
	 * @param array $params New collection data
	 * @return BalanceCollectionInterface
	 */
	public function create( $data, $args = array() ) {
		$collection = parent::create( $data, $args );
		if ( isset( $args['use_whitelist'] ) && $args['use_whitelist'] == true ) {
			$collection->apply_whitelist();
		}
		return $collection;
	}
}
