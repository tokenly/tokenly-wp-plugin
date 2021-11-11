<?php

namespace Tokenly\Wp\Factories;

use Tokenly\Wp\Interfaces\Factories\BalanceCollectionFactoryInterface;
use Tokenly\Wp\Interfaces\Collections\BalanceCollectionInterface;
use Tokenly\Wp\Factories\Factory;

class BalanceCollectionFactory extends Factory implements BalanceCollectionFactoryInterface {
	/**
	 * Creates a new balance collection
	 * @param array $params New balance collection data
	 * @return BalanceCollectionInterface
	 */
	public function create( $balances, $embed_meta = true, $apply_whitelist = true ) {
		$balance_collection = $this->factory->create( array() );
		foreach ( $balances as $balance ) {
			$balance_collection[] = $balance;
		}
		if ( $embed_meta == true ) {
			$balance_collection->embed_meta();
		}
		if ( $apply_whitelist == true ) {
			$balance_collection->apply_whitelist();
		}
		return $balance_collection;
	}
}
