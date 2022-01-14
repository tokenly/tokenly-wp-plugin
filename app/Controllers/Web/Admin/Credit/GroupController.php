<?php

namespace Tokenly\Wp\Controllers\Web\Admin\Credit;

use Tokenly\Wp\Interfaces\Controllers\Web\Admin\Credit\GroupControllerInterface;

use Tokenly\Wp\Interfaces\Presentation\Views\Admin\Credit\GroupStoreViewModelInterface;

/**
 * Serves the admin credit group views
 */
class GroupController implements GroupControllerInterface {
	protected $store_view_model;

	public function __construct(
		GroupStoreViewModelInterface $store_view_model
	) {
		$this->store_view_model = $store_view_model;
	}

	public function index() {
		return array(
			'view' => 'credit-group-index',
		);
	}
	
	public function show() {
		return array(
			'view' => 'credit-group-show',
		);
	}

	public function store() {
		$view_data = $this->store_view_model->prepare();
		return array(
			'view' => 'credit-group-store',
			'data' => $view_data,
		);
	}

	public function edit() {
		return array(
			'view' => 'credit-group-edit',
		);
	}
}
