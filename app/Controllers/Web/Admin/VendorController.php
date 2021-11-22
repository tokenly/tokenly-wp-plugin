<?php

namespace Tokenly\Wp\Controllers\Web\Admin;

use Tokenly\Wp\Interfaces\Controllers\Web\Admin\VendorControllerInterface;
use Tokenly\Wp\Views\Admin\VendorView;
use Tokenly\Wp\Interfaces\Repositories\PromiseRepositoryInterface;
use Tokenly\Wp\Interfaces\Repositories\SourceRepositoryInterface;
use Tokenly\Wp\Interfaces\Models\CurrentUserInterface;

/**
 * Serves the admin Vendor view
 */
class VendorController implements VendorControllerInterface {
	protected $vendor_view;
	protected $promise_repository;
	protected $source_repository;
	protected $current_user;

	public function __construct(
		VendorView $vendor_view,
		PromiseRepositoryInterface $promise_repository,
		SourceRepositoryInterface $source_repository,
		CurrentUserInterface $current_user
	) {
		$this->vendor_view = $vendor_view;
		$this->promise_repository = $promise_repository;
		$this->source_repository = $source_repository;
		$this->current_user = $current_user;
	}

	public function show() {
		if ( $this->current_user->is_guest() === true ) {
			return;
		}
		if ( $this->current_user->can_connect() === false ) {
			return;
		}
		$promises = $this->promise_repository->index( array(
			'with' => array( 'meta' ),
		) );
		$promises = $promises->to_array();
		$sources = $this->source_repository->index( array(
			'with' => array( 'address' ),
		) );
		$sources = $sources->to_array();
		$render = $this->vendor_view->render( array(
			'promises' => $promises,
			'sources'  => $sources,
		) );
		return $render;
	}
}
