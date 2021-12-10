<?php

namespace Tokenly\Wp\Controllers\Web\Admin;

use Tokenly\Wp\Interfaces\Controllers\Web\Admin\CreditGroupControllerInterface;
use Tokenly\Wp\Interfaces\Presentation\Views\Admin\CreditGroupIndexViewModelInterface;
use Tokenly\Wp\Interfaces\Presentation\Views\Admin\CreditGroupShowViewModelInterface;
use Tokenly\Wp\Interfaces\Presentation\Views\Admin\CreditGroupEditViewModelInterface;

/**
 * Serves the admin credit group views
 */
class CreditGroupController implements CreditGroupControllerInterface {
	protected $credit_group_index_view_model;
	protected $credit_group_show_view_model;
	protected $credit_group_edit_view_model;

	public function __construct(
		CreditGroupIndexViewModelInterface $credit_group_index_view_model,
		CreditGroupShowViewModelInterface $credit_group_show_view_model,
		CreditGroupEditViewModelInterface $credit_group_edit_view_model
	) {
		$this->credit_group_index_view_model = $credit_group_index_view_model;
		$this->credit_group_show_view_model = $credit_group_show_view_model;
		$this->credit_group_edit_view_model = $credit_group_edit_view_model;
	}

	public function index() {
		$view_data = $this->credit_group_index_view_model->prepare();
		return array(
			'view' => 'credit-group-index',
			'data' => $view_data,
		);
	}
	
	public function show() {
		if ( !isset( $_GET['credit_group'] ) ) {
			return false;
		}
		$input_data = array(
			'credit_group_uuid' => $_GET['credit_group'],
		);
		$view_data = $this->credit_group_show_view_model->prepare( $input_data );
		return array(
			'view' => 'credit-group-show',
			'data' => $view_data,
		);
	}

	public function store() {
		$view_data = array();
		return array(
			'view' => 'credit-group-store',
			'data' => $view_data,
		);
	}

	public function edit() {
		if ( !isset( $_GET['credit_group'] ) ) {
			return false;
		}
		$input_data = array(
			'credit_group_uuid' => $_GET['credit_group'],
		);
		$view_data = $this->credit_group_edit_view_model->prepare( $input_data );
		return array(
			'view' => 'credit-group-edit',
			'data' => $view_data,
		);
	}
}
