<?php

namespace Tokenly\Wp\Models;

use Tokenly\Wp\Interfaces\Models\BalanceInterface;

class Balance implements BalanceInterface {
	public $name;
	public $balance;
	public $precision;

	public function __construct( 
		$balance_data = array()
	) {
		$this->from_array( $balance_data );
	}

	public function from_array( $balance_data ) {
		if ( isset( $balance_data['name'] ) ) {
			$this->name = $balance_data['name'] ?? null;
		}
		if ( isset( $balance_data['balance'] ) ) {
			$this->balance = $balance_data['balance'] ?? null;
		}
		if ( isset( $balance_data['precision'] ) ) {
			$this->precision = $balance_data['precision'] ?? null;
		}
	}
}
