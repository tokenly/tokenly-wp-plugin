<?php

namespace Tokenly\Wp\Controllers\Web\Admin\Credit;

use Tokenly\Wp\Interfaces\Controllers\Web\Admin\Credit\VendorControllerInterface;

/**
 * Serves the admin Vendor view
 */
class VendorController implements VendorControllerInterface {
	public function show() {
		return array(
			'view' => 'credit-vendor',
		);
	}
}
