<?php

namespace Tokenly\Wp\Models\Token\Access;

use Tokenly\Wp\Models\Model;
use Tokenly\Wp\Interfaces\Models\Token\Access\RuleInterface;

use Tokenly\Wp\Interfaces\Factories\Models\Tca\RuleFactoryInterface;

class Rule extends Model implements RuleInterface {
	/**
	 * Asset name.
	 * @var string 
	 */
	protected ?string $asset = '';
	/**
	 * Quantity to compare.
	 * @var float 
	 */
	protected ?float $quantity = 0;
	/**
	 * Logical operator.
	 * @var string 
	 */
	protected ?string $op = '';
	/**
	 * Group operator.
	 * @var string 
	 */
	protected ?string $stack_op = 'AND';
	/**
	 * @inheritDoc
	 */

	public function get_asset(): ?string {
		return $this->asset ?? null;
	}

	public function set_asset( ?string $value ): void {
		$this->asset = $value;
	}

	public function get_quantity(): ?float {
		return $this->quantity ?? null;
	}

	public function set_quantity( ?float $quantity ): void {
		$this->quantity = $quantity;
	}

	public function get_op(): ?string {
		return $this->op ?? null;
	}

	public function set_op( ?string $value ): void {
		$this->op = $value;
	}

	public function get_stack_op(): ?string {
		return $this->stack_op ?? null;
	}

	public function set_stack_op( ?string $value ): void {
		$this->stack_op = $value;
	}

	/**
	 * Formats the rule for request
	 * @param int $key Rule number
	 * @return array
	 */
	public function format_rule( int $key ): array {
		$rule = array();
		if ( $this->get_asset() && $this->get_quantity() ) {
			$rule[ $this->get_asset() ] = $this->get_quantity();
			$rule[ "op_{$key}" ] = $this->get_op(); 
			if ( $key > 0 ) {
				$rule[ "stackop_{$key}" ] = $this->get_stack_op();
			}
		}
		return $rule;
	}

	/**
	 * @inheritDoc
	 */
	public function to_array(): array {
		return array(
			'asset'    => $this->get_asset(),
			'quantity' => $this->get_quantity(),
			'op'       => $this->get_op(),
			'stack_op' => $this->get_stack_op(),
		);
	}

	protected function get_fillable(): array {
		return array_merge( parent::get_fillable(), array(
			'asset',
			'quantity',
			'op',
			'stack_op',
		) );
	}
}
