<?php

namespace Tokenly\Wp\Controllers\Web\Admin\Token;

use Tokenly\Wp\Interfaces\Controllers\Web\Admin\Token\VendorControllerInterface;
use Tokenly\Wp\Interfaces\Presentation\Views\Admin\Token\VendorViewModelInterface;

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
			'view' => 'token-vendor',
			'data' => $view_data,
		);
	}
}
