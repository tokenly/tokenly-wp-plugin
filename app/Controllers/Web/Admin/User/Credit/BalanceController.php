<?php

namespace Tokenly\Wp\Controllers\Web\Admin\User\Credit;

use Tokenly\Wp\Interfaces\Controllers\Web\Admin\User\Credit\BalanceControllerInterface;

/**
 * Serves the admin balance views
 */
class BalanceController implements BalanceControllerInterface {
	public function index() {
		return array(
			'view' => 'user-credit-balance-index',
		);
	}
}
