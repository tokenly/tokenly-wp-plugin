<?php

namespace Tokenly\Wp\Factories\Models;

use Tokenly\Wp\Interfaces\Factories\Models\BalanceFactoryInterface;
use Tokenly\Wp\Interfaces\Models\BalanceInterface;
use Tokenly\Wp\Factories\Factory;

class BalanceFactory extends Factory implements BalanceFactoryInterface {
	/**
	 * Creates a new balance object
	 * @param array $params New balance data
	 * @return BalanceInterface
	 */
	public function create( $data, $args = array() ) {
		$balance = $this->factory->create( array(
			'balance_data' => array(
				'asset'       => $data['asset'] ?? null,
				'name'        => $data['name'] ?? null,
				'balance'     => $data['balance'] ?? null,
				'balance_sat' => $data['balanceSat'] ?? null,
				'precision'   => $data['precision'] ?? null,
			),
		) );
		return $balance;
	}
}
