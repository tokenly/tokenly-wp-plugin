<?php

namespace Tokenly\Wp\Controllers\Web\Admin;

use Tokenly\Wp\Views\Admin\VendorView;
use Tokenly\Wp\Controllers\Web\WebController;

class VendorController extends WebController {
	public $vendor_view;

	public function __construct( VendorView $vendor_view ) {
		$this->vendor_view = $vendor_view;
	}

	public function show() {
		$render = $this->vendor_view->render( array(
			//
		) );
		echo $render;
	}
}
