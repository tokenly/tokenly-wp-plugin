<?php

namespace Tokenly\Wp\Controllers\Web\Admin;

use Tokenly\Wp\Interfaces\Controllers\Web\Admin\CreditTransactionControllerInterface;
use Tokenly\Wp\Interfaces\Presentation\Views\Admin\CreditTransactionIndexViewModelInterface;
use Tokenly\Wp\Interfaces\Presentation\Views\Admin\CreditTransactionStoreViewModelInterface;

/**
 * Serves the admin credit transaction views
 */
class CreditTransactionController implements CreditTransactionControllerInterface {
	protected $credit_transaction_index_view_model;

	public function __construct(
		CreditTransactionIndexViewModelInterface $credit_transaction_index_view_model,
		CreditTransactionStoreViewModelInterface $credit_transaction_store_view_model
	) {
		$this->credit_transaction_index_view_model = $credit_transaction_index_view_model;
		$this->credit_transaction_store_view_model = $credit_transaction_store_view_model;
	}

	public function index() {
		if ( !isset( $_GET['credit_group'] ) ) {
			return false;
		}
		$input_data = array(
			'group_uuid' => $_GET['credit_group'],
		);
		$view_data = $this->credit_transaction_index_view_model->prepare( $input_data );
		return $view_data;
	}
	
	public function store() {
		$view_data = $this->credit_transaction_store_view_model->prepare();
		return $view_data;
	}
}
