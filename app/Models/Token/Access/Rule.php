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
	public ?string $asset = '';
	/**
	 * Quantity to compare.
	 * @var float 
	 */
	public ?float $quantity = 0;
	/**
	 * Logical operator.
	 * @var string 
	 */
	public ?string $op = '';
	/**
	 * Group operator.
	 * @var string 
	 */
	public ?string $stack_op = 'AND';
	/**
	 * @inheritDoc
	 */

	/**
	 * Formats the rule for request
	 * @param int $key Rule number
	 * @return array
	 */
	public function format_rule( int $key ): array {
		$rule = array();
		if ( $this->asset && $this->quantity ) {
			$rule[ $this->asset ] = $this->quantity;
			$rule[ "op_{$key}" ] = $this->op; 
			if ( $key > 0 ) {
				$rule[ "stackop_{$key}" ] = $this->stack_op;
			}
		}
		return $rule;
	}

	/**
	 * @inheritDoc
	 */
	public function to_array(): array {
		return array(
			'asset'    => $this->asset,
			'quantity' => $this->quantity,
			'op'       => $this->op,
			'stack_op' => $this->stack_op,
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
