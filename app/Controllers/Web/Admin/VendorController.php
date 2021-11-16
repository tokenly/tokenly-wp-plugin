<?php

namespace Tokenly\Wp\Controllers\Web\Admin;

use Tokenly\Wp\Interfaces\Controllers\Web\Admin\VendorControllerInterface;
use Tokenly\Wp\Views\Admin\VendorView;
use Tokenly\Wp\Interfaces\Repositories\PromiseRepositoryInterface;
use Tokenly\Wp\Interfaces\Repositories\SourceRepositoryInterface;

/**
 * Serves the admin Vendor view
 */
class VendorController implements VendorControllerInterface {
	protected $vendor_view;
	protected $promise_repository;
	protected $source_repository;

	public function __construct(
		VendorView $vendor_view,
		PromiseRepositoryInterface $promise_repository,
		SourceRepositoryInterface $source_repository
	) {
		$this->vendor_view = $vendor_view;
		$this->promise_repository = $promise_repository;
		$this->source_repository = $source_repository;
	}

	public function show() {
		$promises = $this->promise_repository->index( array(
			'with' => array( 'meta' ),
		) );
		$sources = $this->source_repository->index();
		$render = $this->vendor_view->render( array(
			'promises' => $promises,
			'sources'  => $sources,
		) );
		echo $render;
	}
}
