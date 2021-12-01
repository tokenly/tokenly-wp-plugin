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

	public function __construct( 
		array $data = array()
	) {
		$this->fill( $data );
	}

	public function fill( array $data ) {
		if ( isset( $data['asset'] ) ) {
			$this->asset = $data['asset'] ?? null;
		}
		if ( isset( $data['name'] ) ) {
			$this->name = $data['name'] ?? null;
		}
		if ( isset( $data['balance'] ) ) {
			$this->balance = floatval( $data['balance'] ?? null );
		}
		if ( isset( $data['balance_sat'] ) ) {
			$this->balance_sat = floatval( $data['balance_sat'] ?? null );
		}
		if ( isset( $data['precision'] ) ) {
			$this->precision = intval( $data['precision'] ?? null );
		}
		if ( 
			isset( $this->balance ) === false && 
			isset( $this->balance_sat ) == true && 
			isset( $this->precision ) === true
		) {
			$this->balance = $this->from_sat( $this->balance_sat, $this->precision );
		}
	}

	public function to_array() {
		$array = array();
		if ( isset( $this->asset ) ) {
			$array['asset'] = $this->asset;
		}
		if ( isset( $this->name ) ) {
			$array['name'] = $this->name;
		}
		if ( isset( $this->balance ) ) {
			$array['balance'] = $this->balance;
		}
		if ( isset( $this->balance_sat ) ) {
			$array['balance_sat'] = $this->balance_sat;
		}
		if ( isset( $this->precision ) ) {
			$array['precision'] = $this->precision;
		}
		if ( isset( $this->meta ) && $this->meta instanceof TokenMetaInterface ) {
			$array['meta'] = $this->meta->to_array();
		}
		return $array;
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
