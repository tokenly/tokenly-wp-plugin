<?php

namespace Tokenly\Wp\Controllers\Web\Admin;

use Tokenly\Wp\Interfaces\Controllers\Web\Admin\CreditTransactionControllerInterface;
use Tokenly\Wp\Views\Admin\CreditTransactionIndexView;
use Tokenly\Wp\Views\Admin\CreditTransactionStoreView;
use Tokenly\Wp\Interfaces\Services\Domain\CreditTransactionServiceInterface;
use Tokenly\Wp\Interfaces\Services\Domain\CreditGroupServiceInterface;

/**
 * Serves the admin credit transaction views
 */
class CreditTransactionController implements CreditTransactionControllerInterface {
	protected $credit_transaction_index_view;
	protected $credit_transaction_store_view;
	protected $credit_transaction_service;
	protected $credit_group_service;

	public function __construct(
		CreditTransactionIndexView $credit_transaction_index_view,
		CreditTransactionStoreView $credit_transaction_store_view,
		CreditTransactionServiceInterface $credit_transaction_service,
		CreditGroupServiceInterface $credit_group_service
	) {
		$this->credit_transaction_index_view = $credit_transaction_index_view;
		$this->credit_transaction_store_view = $credit_transaction_store_view;
		$this->credit_transaction_service = $credit_transaction_service;
		$this->credit_group_service = $credit_group_service;
	}

	public function index() {
		$params = array();
		if ( isset( $_GET['credit_group'] ) ) {
			$params['group_uuid'] = $_GET['credit_group'];
		}
		$credit_transactions = $this->credit_transaction_service->index( $params );
		if ( $credit_transactions ) {
			$credit_transactions = $credit_transactions->to_array();
		} else {
			$credit_transactions = array();
		}
		$render = $this->credit_transaction_index_view->render( array(
			'credit_transactions' => $credit_transactions,
		) );
		return $render;
	}
	
	public function store() {
		$credit_groups = $this->credit_group_service->index();
		$credit_groups = $credit_groups->to_array();
		$render = $this->credit_transaction_store_view->render( array(
			'credit_groups' => $credit_groups,
		) );
		return $render;
	}
}
