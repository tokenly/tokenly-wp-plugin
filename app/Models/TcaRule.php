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
}
