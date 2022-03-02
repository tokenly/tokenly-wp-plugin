<?php

namespace Tokenly\Wp\Controllers\Admin\Credit;

use Tokenly\Wp\Interfaces\Controllers\Admin\Credit\TransactionControllerInterface;

/**
 * Serves the admin credit transaction views
 */
class TransactionController implements TransactionControllerInterface {
	public function index(): array {
		return array(
			'view' => 'credit-transaction-index',
		);
	}
	
	public function store(): array {
		return array(
			'view' => 'credit-transaction-store',
		);
	}
}
