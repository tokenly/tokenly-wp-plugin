<?php

namespace Tokenly\Wp\Controllers\Admin;

use Tokenly\Wp\Interfaces\Controllers\Admin\UserControllerInterface;
use Tokenly\Wp\Interfaces\Models\UserInterface;

/**
 * Serves the admin user views
 */
class UserController implements UserControllerInterface {
	public function show( UserInterface $user ): array {
		return array(
			'view' => 'user-show',
		);
	}

	public function credit_balance_index(): array {
		return array(
			'view' => 'user-credit-balance-index',
		);
	}

	public function token_balance_index(): array {
		return array(
			'view' => 'user-token-balance-index',
		);
	}
}
