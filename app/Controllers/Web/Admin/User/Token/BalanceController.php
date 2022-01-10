<?php

namespace Tokenly\Wp\Controllers\Web\Admin\User\Token;

use Tokenly\Wp\Interfaces\Controllers\Web\Admin\User\Token\BalanceControllerInterface;

/**
 * Serves the admin balance views
 */
class BalanceController implements BalanceControllerInterface {
	public function index() {
		return array(
			'view' => 'user-token-balance-index',
		);
	}
}
