<?php

namespace Tokenly\Wp\Models;

use Tokenly\Wp\Models\Model;
use Tokenly\Wp\Interfaces\Models\QuantityInterface;

class Quantity extends Model implements QuantityInterface {
	public $value;
	public $value_sat;
	public $precision = 0;
	protected $fillable = array(
		'value',
		'value_sat',
		'precision',
	);

	public function __construct(
		array $data = array()
	) {
		parent::__construct( $data );
		$this->get_value();
		$this->get_value_sat();
	}

	public function get_value() {
		if ( isset( $this->value ) ) {
			return $this->value;
		}
		if ( isset( $this->value_sat ) ) {
			$this->value = $this->from_sat( $this->value_sat, $this->precision );
			return $this->value;
		}
	}

	public function get_value_sat() {
		if ( isset( $this->value_sat ) ) {
			return $this->value_sat;
		}
		if ( isset( $this->value ) ) {
			$this->value_sat = $this->to_sat( $this->value, $this->precision );
			return $this->value_sat;
		}
	}

	protected function from_sat( float $value, int $precision = 1 ) {
		if ( $precision == 0 ) {
			return $value;
		}
		$divisor = intval( 1 . str_repeat( 0, $precision ) );
		$value = $value / $divisor;
		return $value;
	}

	protected function to_sat( float $value, int $precision = 0 ) {
		if ( $precision == 0 ) {
			return $value;
		}
		$multiplier = intval( 1 . str_repeat( 0, $precision ) );
		$value = $value * $divisor;
		return $value;
	}
}
