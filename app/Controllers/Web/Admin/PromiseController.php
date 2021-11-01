<?php

namespace Tokenly\Wp\Controllers\Web\Admin;

use Tokenly\Wp\Controllers\Web\WebController;
use Tokenly\Wp\Views\Admin\PromiseStoreView;
use Tokenly\Wp\Repositories\SourceRepository;

class PromiseController extends WebController {
	public $promise_store_view;
	public $source_repository;

	public function __construct(
		PromiseStoreView $promise_store_view,
		SourceRepository $source_repository
	) {
		$this->promise_store_view = $promise_store_view;
		$this->source_repository = $source_repository;
	}

	public function store() {
		$sources = $this->source_repository->index();
		$render = $this->promise_store_view->render( array(
			'sources' => $sources,
		) );
		echo $render;
	}
}
