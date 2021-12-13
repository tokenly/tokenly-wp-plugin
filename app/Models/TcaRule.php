<?php

namespace Tokenly\Wp\Models;

use Tokenly\Wp\Models\Model;
use Tokenly\Wp\Interfaces\Models\TcaRuleInterface;

class TcaRule extends Model implements TcaRuleInterface {
	public $asset;
	public $quantity;
	public $op;
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
