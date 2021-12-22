<?php

namespace Tokenly\Wp\Controllers\Web\Admin\Token;

use Tokenly\Wp\Interfaces\Controllers\Web\Admin\Token\PromiseControllerInterface;
use Tokenly\Wp\Interfaces\Presentation\Views\Admin\Token\PromiseShowViewModelInterface;
use Tokenly\Wp\Interfaces\Presentation\Views\Admin\Token\PromiseStoreViewModelInterface;
use Tokenly\Wp\Interfaces\Presentation\Views\Admin\Token\PromiseEditViewModelInterface;
use Tokenly\Wp\Interfaces\Models\PromiseInterface;

/**
 * Serves the admin promise views
 */
class PromiseController implements PromiseControllerInterface {
	protected $show_view_model;
	protected $store_view_model;
	protected $edit_view_model;

	public function __construct(
		PromiseShowViewModelInterface $show_view_model,
		PromiseStoreViewModelInterface $store_view_model,
		PromiseEditViewModelInterface $edit_view_model
	) {
		$this->show_view_model = $show_view_model;
		$this->store_view_model = $store_view_model;
		$this->edit_view_model = $edit_view_model;
	}
	
	/**
	 * Serves the "Token promise show" admin view
	 * @return array
	 */
	public function show() {
		$input_data = array();
		if ( isset( $_GET['promise'] ) ) {
			$input_data['promise_id'] = intval( $_GET['promise'] );
		} else {
			return false;
		}
		$view_data = $this->show_view_model->prepare( $input_data );
		return array(
			'view' => 'token-promise-show',
			'data' => $view_data,
		);
	}

	/**
	 * Serves the "Token promise store" admin view
	 * @return array
	 */
	public function store() {
		$view_data = $this->store_view_model->prepare();
		return array(
			'view' => 'token-promise-store',
			'data' => $view_data,
		);
	}

	/**
	 * Serves the "Token promise edit" admin view
	 * @return array
	 */
	public function edit() {
		$input_data = array();
		if ( isset( $_GET['promise'] ) ) {
			$input_data['promise_id'] = intval( $_GET['promise'] );
		} else {
			return false;
		}
		$view_data = $this->edit_view_model->prepare( $input_data );
		return array(
			'view' => 'token-promise-edit',
			'data' => $view_data,
		);
	}
}
