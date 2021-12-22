<?php

namespace Tokenly\Wp\Models;

use Tokenly\Wp\Models\Model;
use Tokenly\Wp\Interfaces\Models\CreditAccountHistoryInterface;

class CreditAccountHistory extends Model implements CreditAccountHistoryInterface {
	public $account;
	public $count;
	public $transactions;
	protected $fillable = array(
		'account',
		'count',
		'transactions',
	);
}
