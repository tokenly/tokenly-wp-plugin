<?php

namespace Tokenly\Wp\Models\Credit;

use Tokenly\Wp\Models\Model;
use Tokenly\Wp\Interfaces\Models\Credit\AccountHistoryInterface;

class AccountHistory extends Model implements AccountHistoryInterface {
	public $account;
	public $count;
	public $transactions;
	protected $fillable = array(
		'account',
		'count',
		'transactions',
	);
}
