<?php

namespace Tokenly\Wp\Models\Tca;

use Tokenly\Wp\Models\Model;
use Tokenly\Wp\Interfaces\Models\Tca\RuleCheckResultInterface;

class RuleCheckResult extends Model implements RuleCheckResultInterface {
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
