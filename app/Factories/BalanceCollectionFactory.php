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
	public function create( $balances, $use_whitelist = true, $use_meta = true ) {
		$balance_collection = $this->factory->create( array(
			'balances'      => $balances,
			'use_whitelist' => $use_whitelist,
			'use_meta'      => $use_meta,
		) );
		return $balance_collection;
	}
}
