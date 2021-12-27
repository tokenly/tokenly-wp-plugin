<?php

namespace Tokenly\Wp\Controllers\Web\Admin\Credit;

use Tokenly\Wp\Interfaces\Controllers\Web\Admin\Credit\GroupControllerInterface;
use Tokenly\Wp\Interfaces\Presentation\Views\Admin\Credit\GroupIndexViewModelInterface;
use Tokenly\Wp\Interfaces\Presentation\Views\Admin\Credit\GroupShowViewModelInterface;
use Tokenly\Wp\Interfaces\Presentation\Views\Admin\Credit\GroupStoreViewModelInterface;
use Tokenly\Wp\Interfaces\Presentation\Views\Admin\Credit\GroupEditViewModelInterface;

/**
 * Serves the admin credit group views
 */
class GroupController implements GroupControllerInterface {
	protected $index_view_model;
	protected $show_view_model;
	protected $edit_view_model;
	protected $store_view_model;

	public function __construct(
		GroupIndexViewModelInterface $index_view_model,
		GroupShowViewModelInterface $show_view_model,
		GroupStoreViewModelInterface $store_view_model,
		GroupEditViewModelInterface $edit_view_model
	) {
		$this->index_view_model = $index_view_model;
		$this->show_view_model = $show_view_model;
		$this->store_view_model = $store_view_model;
		$this->edit_view_model = $edit_view_model;
	}

	public function index() {
		$view_data = $this->index_view_model->prepare();
		return array(
			'view' => 'credit-group-index',
			'data' => $view_data,
		);
	}
	
	public function show() {
		$input_data = array();
		$view_data = $this->show_view_model->prepare( $input_data );
		return array(
			'view' => 'credit-group-show',
			'data' => $view_data,
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
		$input_data = array();
		$view_data = $this->edit_view_model->prepare( $input_data );
		return array(
			'view' => 'credit-group-edit',
			'data' => $view_data,
		);
	}
}
