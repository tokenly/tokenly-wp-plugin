<?php

namespace Tokenly\Wp\Controllers\Web\Admin;

use Tokenly\Wp\Interfaces\Controllers\Web\Admin\VendorControllerInterface;
use Tokenly\Wp\ViewModels\Admin\VendorViewModel;

/**
 * Serves the admin Vendor view
 */
class VendorController implements VendorControllerInterface {
	protected $vendor_view_model;

	public function __construct(
		VendorViewModel $vendor_view_model
	) {
		$this->vendor_view_model = $vendor_view_model;
	}

	public function show() {
		$view_data = $this->vendor_view_model->prepare();
		return $view_data;
	}
}
