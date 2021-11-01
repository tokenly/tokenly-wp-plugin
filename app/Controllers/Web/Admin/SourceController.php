<?php

namespace Tokenly\Wp\Controllers\Web\Admin;

use Tokenly\Wp\Controllers\Web\WebController;
use Tokenly\Wp\Views\Admin\SourceIndexView;
use Tokenly\Wp\Views\Admin\SourceStoreView;
use Tokenly\Wp\Views\Admin\SourceEditView;
use Tokenly\Wp\Repositories\SourceRepository;

class SourceController extends WebController {
	public $source_index_view;
	public $source_store_view;
	public $source_edit_view;
	public $source_repository;

	public function __construct(
		SourceIndexView $source_index_view,
		SourceStoreView $source_store_view,
		SourceEditView $source_edit_view,
		SourceRepository $source_repository
	) {
		$this->source_index_view = $source_index_view;
		$this->source_store_view = $source_store_view;
		$this->source_edit_view = $source_edit_view;
		$this->source_repository = $source_repository;
	}

	public function index() {
		$sources = $this->source_repository->index();
		$render = $this->source_index_view->render( array(
			'sources' => $sources,
		) );
		echo $render;
	}

	public function store() {
		$render = $this->source_store_view->render( array(
			//
		) );
		echo $render;
	}

	public function edit() {
		$source_address = $_GET['source'] ?? null;
		$source = $this->source_repository->show( $source_address );
		$render = $this->source_edit_view->render( array(
			'source' => $source,
		) );
		echo $render;
	}
}
