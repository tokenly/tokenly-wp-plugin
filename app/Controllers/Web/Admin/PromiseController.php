<?php

namespace Tokenly\Wp\Controllers\Web\Admin;

use Tokenly\Wp\Interfaces\Controllers\Web\Admin\PromiseControllerInterface;
use Tokenly\Wp\Views\Admin\PromiseStoreView;
use Tokenly\Wp\Views\Admin\PromiseEditView;;
use Tokenly\Wp\Interfaces\Repositories\SourceRepositoryInterface;
use Tokenly\Wp\Interfaces\Repositories\PromiseRepositoryInterface;

/**
 * Serves the admin promise views
 */
class PromiseController implements PromiseControllerInterface {
	public $promise_store_view;
	public $promise_edit_view;
	public $promise_repository;
	public $source_repository;

	public function __construct(
		PromiseStoreView $promise_store_view,
		PromiseEditView $promise_edit_view,
		SourceRepositoryInterface $source_repository,
		PromiseRepositoryInterface $promise_repository
	) {
		$this->promise_store_view = $promise_store_view;
		$this->promise_edit_view = $promise_edit_view;
		$this->source_repository = $source_repository;
		$this->promise_repository = $promise_repository;
	}

	public function index() {
		$promises = $this->promise_repository->index();
		//
	}

	public function store() {
		$sources = $this->source_repository->index();
		$render = $this->promise_store_view->render( array(
			'sources' => $sources,
		) );
		echo $render;
	}

	public function edit() {
		$promise_id = $_GET['promise'] ?? null;
		$promise = $this->promise_repository->show( $promise_id );
		$render = $this->promise_edit_view->render( array(
			'promise' => $promise,
		) );
		echo $render;
	}
}
