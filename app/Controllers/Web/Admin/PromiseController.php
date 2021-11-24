<?php

namespace Tokenly\Wp\Controllers\Web\Admin;

use Tokenly\Wp\Interfaces\Controllers\Web\Admin\PromiseControllerInterface;
use Tokenly\Wp\Interfaces\Services\Domain\SourceServiceInterface;
use Tokenly\Wp\Interfaces\Services\Domain\PromiseServiceInterface;
use Tokenly\Wp\Views\Admin\PromiseShowView;
use Tokenly\Wp\Views\Admin\PromiseStoreView;
use Tokenly\Wp\Views\Admin\PromiseEditView;

/**
 * Serves the admin promise views
 */
class PromiseController implements PromiseControllerInterface {
	protected $promise_show_view;
	protected $promise_store_view;
	protected $promise_edit_view;
	protected $promise_service;
	protected $source_service;

	public function __construct(
		PromiseShowView $promise_show_view,
		PromiseStoreView $promise_store_view,
		PromiseEditView $promise_edit_view,
		SourceServiceInterface $source_service,
		PromiseServiceInterface $promise_service
	) {
		$this->promise_show_view = $promise_show_view;
		$this->promise_store_view = $promise_store_view;
		$this->promise_edit_view = $promise_edit_view;
		$this->source_service = $source_service;
		$this->promise_service = $promise_service;
	}

	public function index() {
		$promises = $this->promise_service->index( array(
			'with'    => array( 'address' ),
		) );
	}
	
	public function show() {
		$promise_id = intval( $_GET['promise'] ?? null );
		$promise = $this->promise_service->show( $promise_id, array(
			'with'    => array(
				'meta',
			),
		) );
		if ( !$promise ) {
			return;
		}
		$promise = $promise->to_array();
		$sources = $this->source_service->index( array(
			'with' => array( 'address' ),
		) );
		$sources = $sources->to_array();
		$render = $this->promise_show_view->render( array(
			'promise' => $promise,
			'sources' => $sources,
		) );
		return $render;
	}

	public function store() {
		$sources = $this->source_service->index( array(
			'with'    => array( 'address' ),
		) );
		$render = $this->promise_store_view->render( array(
			'sources' => $sources,
		) );
		return $render;
	}

	public function edit() {
		$promise_id = $_GET['promise'] ?? null;
		$promise = $this->promise_service->show( $promise_id );
		if ( $promise ) {
			$promise = $promise->to_array();
		}
		$render = $this->promise_edit_view->render( array(
			'promise' => $promise,
		) );
		return $render;
	}
}
