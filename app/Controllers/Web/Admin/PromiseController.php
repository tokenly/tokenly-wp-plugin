<?php

namespace Tokenly\Wp\Controllers\Web\Admin;

use Tokenly\Wp\Interfaces\Controllers\Web\Admin\PromiseControllerInterface;
use Tokenly\Wp\ViewModels\Admin\PromiseShowViewModel;
use Tokenly\Wp\ViewModels\Admin\PromiseStoreViewModel;
use Tokenly\Wp\ViewModels\Admin\PromiseEditViewModel;

/**
 * Serves the admin promise views
 */
class PromiseController implements PromiseControllerInterface {
	protected $promise_show_view_model;
	protected $promise_store_view_model;
	protected $promise_edit_view_model;

	public function __construct(
		PromiseShowViewModel $promise_show_view_model,
		PromiseStoreViewModel $promise_store_view_model,
		PromiseEditViewModel $promise_edit_view_model
	) {
		$this->promise_show_view_model = $promise_show_view_model;
		$this->promise_store_view_model = $promise_store_view_model;
		$this->promise_edit_view_model = $promise_edit_view_model;
	}
	
	public function show() {
		if ( !isset( $_GET['promise'] ) ) {
			return false;
		}
		$input_data = array(
			'promise_id' => intval( $_GET['promise'] ),
		);
		$view_data = $this->promise_show_view_model->prepare( $input_data );
		return $view_data;
	}

	public function store() {
		$view_data = $this->promise_store_view_model->prepare();
		return $view_data;
	}

	public function edit() {
		if ( !isset( $_GET['promise'] ) ) {
			return false;
		}
		$input_data = array(
			'promise_id' => intval( $_GET['promise'] ),
		);
		$view_data = $this->promise_edit_view_model->prepare( $input_data );
		return $view_data;
	}
}
