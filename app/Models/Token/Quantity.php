<?php

namespace Tokenly\Wp\Models\Token;

use Tokenly\Wp\Models\Model;
use Tokenly\Wp\Interfaces\Models\Token\QuantityInterface;

class Quantity extends Model implements QuantityInterface {
	public ?float $value = 0;
	public ?float $value_sat = 0;
	public ?int $precision = 0;

	/**
	 * @inheritDoc
	 */
	public function from_array( array $data = array() ): self {
		return parent::from_array( $data );
	}

	/**
	 * @inheritDoc
	 */
	public function to_array(): array {
		$array = array(
			'value'     => $this->value,
			'value_sat' => $this->value_sat,
			'precision' => $this->precision,
		);
		return $array;
	}

	/**
	 * @inheritDoc
	 */
	protected function get_fillable(): array {
		return array_merge( parent::get_fillable(), array(
			'value',
			'value_sat',
			'precision',
		) );
	}
}
