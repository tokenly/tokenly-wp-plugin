<?php

namespace Tokenly\Wp\Models;

use Tokenly\Wp\Models\Model;
use Tokenly\Wp\Interfaces\Models\TcaRuleCheckResultInterface;

class TcaRuleCheckResult extends Model implements TcaRuleCheckResultInterface {
	/**
	 * Hash based on the attributes of the rule.
	 * @var string
	 */
	public $hash;
	/**
	 * Check result.
	 * @var bool 
	 */
	public $status;
	protected $fillable = array(
		'hash',
		'status',
	);
}
