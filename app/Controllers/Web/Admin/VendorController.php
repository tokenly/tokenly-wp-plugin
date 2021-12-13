<?php

namespace Tokenly\Wp\Controllers\Web\Admin;

use Tokenly\Wp\Interfaces\Controllers\Web\Admin\VendorControllerInterface;
use Tokenly\Wp\Interfaces\Presentation\Views\Admin\VendorViewModelInterface;

/**
 * Serves the admin Vendor view
 */
class VendorController implements VendorControllerInterface {
	protected $vendor_view_model;

	public function __construct(
		VendorViewModelInterface $vendor_view_model
	) {
		$this->vendor_view_model = $vendor_view_model;
	}

	public function show() {
		$view_data = $this->vendor_view_model->prepare();
		return array(
			'view' => 'vendor',
			'data' => $view_data,
		);
	}
}
