<?php

namespace Tokenly\Wp\Models;

use Tokenly\Wp\Models\Model;
use Tokenly\Wp\Interfaces\Models\CreditGroupHistoryInterface;

class CreditGroupHistory extends Model implements CreditGroupHistoryInterface {
	public $balance;
	public $count;
	public $transactions;
	protected $fillable = array(
		'balance',
		'count',
		'transactions',
	);
}
