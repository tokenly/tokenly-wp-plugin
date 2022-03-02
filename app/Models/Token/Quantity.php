<?php

namespace Tokenly\Wp\Models\Token;

use Tokenly\Wp\Models\Model;
use Tokenly\Wp\Interfaces\Models\Token\QuantityInterface;

class Quantity extends Model implements QuantityInterface {
	protected ?float $value = 0;
	protected ?float $value_sat = 0;
	protected ?int $precision = 0;

	/**
	 * Gets the Value property
	 * @return float|null
	 */
	public function get_value(): ?float {
		return $this->value ?? null;
	}

	/**
	 * Sets the Value property
	 * @param float $value New value
	 * @return void
	 */
	public function set_value( ?float $value ): void {
		$this->value = $value;
	}

	/**
	 * Gets the Satoshi equivalent of the value
	 * @return float|null
	 */
	public function get_value_sat(): ?float {
		return $this->value_sat ?? null;
	}

	/**
	 * Sets the Value(Sat) property
	 * @param float $value New value
	 * @return void
	 */
	public function set_value_sat( ?float $value ): void {
		$this->value_sat = $value;
	} 

	/**
	 * Gets the Precision property
	 * @return int|null
	 */
	public function get_precision(): ?int {
		return $this->precision ?? null;
	}

	/**
	 * Sets the Precision property
	 * @param int $value New value
	 * @return void
	 */
	public function set_precision( ?int $value ): void {
		$this->precision = $value;
	}

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
			'value'     => $this->get_value(),
			'value_sat' => $this->get_value_sat(),
			'precision' => $this->get_precision(),
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
