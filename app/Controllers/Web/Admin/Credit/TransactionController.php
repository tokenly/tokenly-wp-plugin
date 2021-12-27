<?php

namespace Tokenly\Wp\Controllers\Web\Admin\Credit;

use Tokenly\Wp\Interfaces\Controllers\Web\Admin\Credit\TransactionControllerInterface;
use Tokenly\Wp\Interfaces\Presentation\Views\Admin\Credit\TransactionIndexViewModelInterface;
use Tokenly\Wp\Interfaces\Presentation\Views\Admin\Credit\TransactionStoreViewModelInterface;

/**
 * Serves the admin credit transaction views
 */
class TransactionController implements TransactionControllerInterface {
	protected $index_view_model;
	protected $store_view_model;

	public function __construct(
		TransactionIndexViewModelInterface $index_view_model,
		TransactionStoreViewModelInterface $store_view_model
	) {
		$this->index_view_model = $index_view_model;
		$this->store_view_model = $store_view_model;
	}

	public function index() {
		$input_data = array();
		$view_data = $this->index_view_model->prepare( $input_data );
		return array(
			'view' => 'credit-transaction-index',
			'data' => $view_data,
		);
	}
	
	public function store() {
		$view_data = $this->store_view_model->prepare();
		return array(
			'view' => 'credit-transaction-store',
			'data' => $view_data,
		);
	}
}
