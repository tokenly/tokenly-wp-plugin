<?php

namespace Tokenly\Wp\Controllers\Web\Admin\Credit;

use Tokenly\Wp\Interfaces\Controllers\Web\Admin\Credit\TransactionControllerInterface;

/**
 * Serves the admin credit transaction views
 */
class TransactionController implements TransactionControllerInterface {
	public function index() {
		return array(
			'view' => 'credit-transaction-index',
		);
	}
	
	public function store() {
		return array(
			'view' => 'credit-transaction-store',
		);
	}
}
