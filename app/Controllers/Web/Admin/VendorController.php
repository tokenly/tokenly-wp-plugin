<?php

namespace Tokenly\Wp\Controllers\Web\Admin;

use Tokenly\Wp\Interfaces\Controllers\Web\Admin\VendorControllerInterface;
use Tokenly\Wp\Interfaces\Services\Domain\PromiseServiceInterface;
use Tokenly\Wp\Interfaces\Services\Domain\SourceServiceInterface;
use Tokenly\Wp\Interfaces\Models\CurrentUserInterface;
use Tokenly\Wp\Views\Admin\VendorView;

/**
 * Serves the admin Vendor view
 */
class VendorController implements VendorControllerInterface {
	protected $vendor_view;
	protected $promise_service;
	protected $source_service;
	protected $current_user;

	public function __construct(
		VendorView $vendor_view,
		PromiseServiceInterface $promise_service,
		SourceServiceInterface $source_service,
		CurrentUserInterface $current_user
	) {
		$this->vendor_view = $vendor_view;
		$this->promise_service = $promise_service;
		$this->source_service = $source_service;
		$this->current_user = $current_user;
	}

	public function show() {
		if ( $this->current_user->is_guest() === true ) {
			return;
		}
		if ( $this->current_user->can_connect() === false ) {
			return;
		}
		$promises = $this->promise_service->index( array(
			'with' => array( 'meta' ),
		) );
		$promises = $promises->to_array();
		$sources = $this->source_service->index( array(
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
