<?php

namespace Tokenly\Wp\Models;

use Tokenly\Wp\Interfaces\Models\BalanceInterface;

class Balance implements BalanceInterface {
	public $asset;
	public $name;
	public $balance;
	public $balance_sat;
	public $precision;

	public function __construct( 
		$balance_data = array()
	) {
		$this->from_array( $balance_data );
	}

	public function to_array() {
		$array = array(
			'asset'       => $this->asset,
			'name'        => $this->name,
			'balance'     => $this->balance,
			'balance_sat' => $this->balance_sat,
			'precision'   => $this->precision,
		);
		return $array;
	}

	protected function from_array( $balance_data ) {
		if ( isset( $balance_data['asset'] ) ) {
			$this->asset = $balance_data['asset'] ?? null;
		}
		if ( isset( $balance_data['name'] ) ) {
			$this->name = $balance_data['name'] ?? null;
		}
		if ( isset( $balance_data['balance'] ) ) {
			$this->balance = floatval( $balance_data['balance'] ?? null );
		}
		if ( isset( $balance_data['balance_sat'] ) ) {
			$this->balance_sat = floatval( $balance_data['balance_sat'] ?? null );
		}
		if ( isset( $balance_data['precision'] ) ) {
			$this->precision = intval( $balance_data['precision'] ?? null );
		}
		if ( 
			isset( $this->balance ) === false && 
			isset( $this->balance_sat ) == true && 
			isset( $this->precision ) === true
		) {
			$this->balance = $this->from_sat( $this->balance_sat, $this->precision );
		}
	}

	public function from_sat( $value, $precision = 1 ) {
		if ( $precision == 0 ) {
			return $value;
		}
		$divisor = intval( 1 . str_repeat( 0, $precision ) );
		$value = $value / $divisor;
		return $value;
	}

	public function to_sat( $value, $precision ) {
		if ( $precision == 0 ) {
			return $value;
		}
		$multiplier = intval( 1 . str_repeat( 0, $precision ) );
		$value = $value * $divisor;
		return $value;
	}
}
