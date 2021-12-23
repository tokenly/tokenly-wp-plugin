<?php

namespace Tokenly\Wp\Models\Tca;

use Tokenly\Wp\Models\Model;
use Tokenly\Wp\Interfaces\Models\Tca\RuleInterface;

class Rule extends Model implements RuleInterface {
	/**
	 * Asset name.
	 * @var string 
	 */
	public $asset;
	/**
	 * Quantity to compare.
	 * @var float 
	 */
	public $quantity;
	/**
	 * Logical operator.
	 * @var string 
	 */
	public $op;
	/**
	 * Group operator.
	 * @var string 
	 */
	public $stackOp;
	protected $fillable = array(
		'asset',
		'quantity',
		'op',
		'stackOp',
	);
	
	/**
	 * Formats the rule for request
	 * @param int $key Rule number
	 * @return array
	 */
	public function format_rule( int $key ) {
		$rule = array();
		$rule[ $this->asset ] = $this->quantity;
		$rule[ "op_{$key}" ] = $this->op; 
		if ( $key > 0 ) {
			$rule[ "stackop_{$key}" ] = $this->stackOp;
		}
		return $rule;
	}
}
