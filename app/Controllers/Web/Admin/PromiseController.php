<?php

namespace Tokenly\Wp\Controllers\Web\Admin;

use Tokenly\Wp\Controllers\Web\WebController;
use Tokenly\Wp\Views\Admin\PromiseStoreView;

class PromiseController extends WebController {
	public $promise_store_view;

	public function __construct(
		PromiseStoreView $promise_store_view
	) {
		$this->promise_store_view = $promise_store_view;
	}

	public function store() {
		$render = $this->promise_store_view->render( array(
			//
		) );
		echo $render;
	}
}
