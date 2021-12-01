<?php

namespace Tokenly\Wp\Models;

use Tokenly\Wp\Models\Model;
use Tokenly\Wp\Interfaces\Models\BalanceInterface;
use Tokenly\Wp\Interfaces\Models\TokenMetaInterface;

class Balance extends Model implements BalanceInterface {
	public $asset;
	public $name;
	public $balance;
	public $balance_sat;
	public $precision;
	public $meta;

	public function fill( array $data ) {
		parent::fill( $data );
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
