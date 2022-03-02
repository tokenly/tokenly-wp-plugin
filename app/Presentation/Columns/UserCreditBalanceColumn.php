<?php

namespace Tokenly\Wp\Presentation\Columns;

use Tokenly\Wp\Interfaces\Presentation\Columns\UserCreditBalanceColumnInterface;

class UserCreditBalanceColumn implements UserCreditBalanceColumnInterface {
	/**
	 * @inheritDoc
	 */
	public function column_callback( int $user_id, array $data = array() ): array {
		return array(
			'user'  => $user_id,
			'group' => $data['uuid'],
		);
	}
}
