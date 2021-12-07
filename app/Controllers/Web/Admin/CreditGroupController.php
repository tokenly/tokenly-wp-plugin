<?php

namespace Tokenly\Wp\Controllers\Web\Admin;

use Tokenly\Wp\Interfaces\Controllers\Web\Admin\CreditGroupControllerInterface;
use Tokenly\Wp\Views\Admin\CreditGroupIndexView;
use Tokenly\Wp\Views\Admin\CreditGroupShowView;
use Tokenly\Wp\Views\Admin\CreditGroupStoreView;
use Tokenly\Wp\Views\Admin\CreditGroupEditView;
use Tokenly\Wp\Interfaces\Services\Domain\CreditGroupServiceInterface;

/**
 * Serves the admin credit group views
 */
class CreditGroupController implements CreditGroupControllerInterface {
	protected $credit_group_index_view;
	protected $credit_group_show_view;
	protected $credit_group_store_view;
	protected $credit_group_edit_view;
	protected $credit_group_service;

	public function __construct(
		CreditGroupIndexView $credit_group_index_view,
		CreditGroupShowView $credit_group_show_view,
		CreditGroupStoreView $credit_group_store_view,
		CreditGroupEditView $credit_group_edit_view,
		CreditGroupServiceInterface $credit_group_service
	) {
		$this->credit_group_index_view = $credit_group_index_view;
		$this->credit_group_show_view = $credit_group_show_view;
		$this->credit_group_store_view = $credit_group_store_view;
		$this->credit_group_edit_view = $credit_group_edit_view;
		$this->credit_group_service = $credit_group_service;
	}

	public function index() {
		$credit_groups = $this->credit_group_service->index();
		$credit_groups = $credit_groups->to_array();
		$render = $this->credit_group_index_view->render( array(
			'credit_groups' => $credit_groups,
		) );
		return $render;
	}
	
	public function show() {
		if ( !isset( $_GET['credit_group'] ) ) {
			return false;
		}
		$credit_group_uuid = $_GET['credit_group'];
		$credit_group = $this->credit_group_service->show( array(
			'uuid' => $credit_group_uuid,
		) );
		if ( !$credit_group ) {
			return false;
		}
		$credit_group = $credit_group->to_array();
		$render = $this->credit_group_show_view->render( array(
			'credit_group' => $credit_group,
		) );
		return $render;
	}

	public function store() {
		$render = $this->credit_group_store_view->render();
		return $render;
	}

	public function edit() {
		if ( !isset( $_GET['credit_group'] ) ) {
			return false;
		}
		$credit_group_uuid = $_GET['credit_group'];
		$credit_group = $this->credit_group_service->show( array(
			'uuid' => $credit_group_uuid,
		) );
		if ( !$credit_group ) {
			return false;
		}
		$credit_group = $credit_group->to_array();
		$render = $this->credit_group_edit_view->render( array(
			'credit_group' => $credit_group,
		) );
		return $render;
	}
}
