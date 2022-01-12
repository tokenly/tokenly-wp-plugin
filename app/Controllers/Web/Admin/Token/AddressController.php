<?php

namespace Tokenly\Wp\Controllers\Web\Admin\Token;

use Tokenly\Wp\Interfaces\Controllers\Web\Admin\Token\AddressControllerInterface;

/**
 * Serves the admin address views
 */
class AddressController implements AddressControllerInterface {
	public function balance_index() {
		return array(
			'view' => 'token-address-balance-index',
		);
	}
}
