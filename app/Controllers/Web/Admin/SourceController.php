<?php

namespace Tokenly\Wp\Controllers\Web\Admin;

use Tokenly\Wp\Controllers\Web\WebController;
use Tokenly\Wp\Views\Admin\SourceIndexView;
use Tokenly\Wp\Views\Admin\SourceStoreView;

class SourceController extends WebController {
	public $source_index_view;
	public $source_store_view;

	public function __construct(
		SourceIndexView $source_index_view,
		SourceStoreView $source_store_view
	) {
		$this->source_index_view = $source_index_view;
		$this->source_store_view = $source_store_view;
	}

	public function index() {
		$render = $this->source_index_view->render( array(
			//
		) );
		echo $render;
	}

	public function store() {
		$render = $this->source_store_view->render( array(
			//
		) );
		echo $render;
	}
}
