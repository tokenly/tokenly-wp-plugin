<?php

namespace Tokenly\Wp\Controllers\Web\Admin\Credit;

use Tokenly\Wp\Interfaces\Controllers\Web\Admin\Credit\BalanceControllerInterface;

use Tokenly\Wp\Interfaces\Presentation\Views\Admin\Credit\BalanceIndexViewModelInterface;

/**
 * Serves the admin credit transaction views
 */
class BalanceController implements BalanceControllerInterface {
	protected $index_view_model;

	public function __construct(
		BalanceIndexViewModelInterface $index_view_model
	) {
		$this->index_view_model = $index_view_model;
	}

	public function index() {
		if ( isset( $_GET['user'] ) ) {
			$input_data['user'] = $_GET['user'];
		} else {
			return false;
		}
		$view_data = $this->index_view_model->prepare( $input_data );
		return array(
			'view' => 'credit-balance-index',
			'data' => $view_data,
		);
	}
}
