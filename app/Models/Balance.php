<?php

namespace Tokenly\Wp\Models;

use Tokenly\Wp\Interfaces\Models\BalanceInterface;

class Balance implements BalanceInterface {
	public $asset;
	public $name;
	public $balance;
	public $balance_sat;

	public function __construct( 
		$balance_data = array()
	) {
		$this->asset = $balance_data['asset'] ?? null;
		$this->name = $balance_data['name'] ?? null;
		$this->balance = $balance_data['balance'] ?? null;
		$this->balance_sat = $balance_data['balanceSat'] ?? null;
	}
}
