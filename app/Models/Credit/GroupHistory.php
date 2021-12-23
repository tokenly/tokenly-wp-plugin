<?php

namespace Tokenly\Wp\Models\Credit;

use Tokenly\Wp\Models\Model;
use Tokenly\Wp\Interfaces\Models\Credit\GroupHistoryInterface;

class CreditGroupHistory extends Model implements GroupHistoryInterface {
	public $balance;
	public $count;
	public $transactions;
	protected $fillable = array(
		'balance',
		'count',
		'transactions',
	);
}
