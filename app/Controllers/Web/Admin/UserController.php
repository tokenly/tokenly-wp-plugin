<?php

namespace Tokenly\Wp\Controllers\Web\Admin;

use Tokenly\Wp\Interfaces\Controllers\Web\Admin\UserControllerInterface;

/**
 * Serves the admin user views
 */
class UserController implements UserControllerInterface {
	public function credit_balance_index() {
		return array(
			'view' => 'user-credit-balance-index',
		);
	}

	public function token_balance_index() {
		return array(
			'view' => 'user-token-balance-index',
		);
	}
}
