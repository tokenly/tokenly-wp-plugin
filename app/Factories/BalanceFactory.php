<?php

namespace Tokenly\Wp\Factories;

use Tokenly\Wp\Interfaces\Factories\BalanceFactoryInterface;
use Tokenly\Wp\Interfaces\Models\BalanceInterface;
use Tokenly\Wp\Factories\Factory;

class BalanceFactory extends Factory implements BalanceFactoryInterface {
	/**
	 * Creates a new balance object
	 * @param array $params New balance data
	 * @return BalanceInterface
	 */
	public function create( $params ) {
		$balance = $this->factory->create( array(
			'balance_data' => array(
				'asset'       => $params['asset'] ?? null,
				'name'        => $params['name'] ?? null,
				'balance'     => $params['balance'] ?? null,
				'balance_sat' => $params['balanceSat'] ?? null,
				'precision'   => $params['precision'] ?? null,
			),
		) );
		return $balance;
	}
}
