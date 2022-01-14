<?php

namespace Tokenly\Wp\Controllers\Web\Admin\Token;

use Tokenly\Wp\Interfaces\Controllers\Web\Admin\Token\VendorControllerInterface;

/**
 * Serves the admin Vendor view
 */
class VendorController implements VendorControllerInterface {
	public function show() {
		return array(
			'view' => 'token-vendor',
		);
	}
}
