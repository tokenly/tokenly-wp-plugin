<?php

namespace Tokenly\Wp\Controllers\Web\Admin;

use Tokenly\Wp\Views\Admin\VendorView;
use Tokenly\Wp\Controllers\Web\WebController;
use Tokenly\Wp\Repositories\PromiseRepository;

/**
 * Serves the admin Vendor view
 */
class VendorController extends WebController {
	public $vendor_view;
	public $promise_repository;

	public function __construct(
		VendorView $vendor_view,
		PromiseRepository $promise_repository
	) {
		$this->vendor_view = $vendor_view;
		$this->promise_repository = $promise_repository;
	}

	public function show() {
		$promises = $this->promise_repository->index();
		$render = $this->vendor_view->render( array(
			'promises' => $promises,
		) );
		echo $render;
	}
}
