<?php

namespace Tokenly\Wp\Controllers\Web\Admin;

use Tokenly\Wp\Interfaces\Controllers\Web\Admin\PromiseControllerInterface;
use Tokenly\Wp\Interfaces\Presentation\Views\Admin\PromiseShowViewModelInterface;
use Tokenly\Wp\Interfaces\Presentation\Views\Admin\PromiseStoreViewModelInterface;
use Tokenly\Wp\Interfaces\Presentation\Views\Admin\PromiseEditViewModelInterface;
use Tokenly\Wp\Interfaces\Models\PromiseInterface;

/**
 * Serves the admin promise views
 */
class PromiseController implements PromiseControllerInterface {
	protected $promise_show_view_model;
	protected $promise_store_view_model;
	protected $promise_edit_view_model;

	public function __construct(
		PromiseShowViewModelInterface $promise_show_view_model,
		PromiseStoreViewModelInterface $promise_store_view_model,
		PromiseEditViewModelInterface $promise_edit_view_model
	) {
		$this->promise_show_view_model = $promise_show_view_model;
		$this->promise_store_view_model = $promise_store_view_model;
		$this->promise_edit_view_model = $promise_edit_view_model;
	}
	
	public function show( PromiseInterface $promise ) {
		error_log(d($_GET));
		$input_data = array(
			'promise' => $promise,
		);
		error_log( d( $promise ) );
		$view_data = $this->promise_show_view_model->prepare( $input_data );
		
		return array(
			'view' => 'promise-show',
			'data' => $view_data,
		);
	}

	public function store() {
		$view_data = $this->promise_store_view_model->prepare();
		return array(
			'view' => 'promise-store',
			'data' => $view_data,
		);
	}

	public function edit() {
		if ( !isset( $_GET['promise'] ) ) {
			return false;
		}
		$input_data = array(
			'promise_id' => intval( $_GET['promise'] ),
		);
		$view_data = $this->promise_edit_view_model->prepare( $input_data );
		return array(
			'view' => 'promise-edit',
			'data' => $view_data,
		);
	}
}
