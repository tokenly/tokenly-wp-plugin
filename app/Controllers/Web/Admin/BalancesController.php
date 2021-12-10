<?php

namespace Tokenly\Wp\Controllers\Web\Admin;

use Tokenly\Wp\Interfaces\Controllers\Web\Admin\BalancesControllerInterface;
use Tokenly\Wp\Interfaces\Presentation\Views\Admin\BalancesShowViewModelInterface;

/**
 * Serves the admin balance views
 */
class BalancesController implements BalancesControllerInterface {
	protected $balances_show_view_model;

	public function __construct(
		BalancesShowViewModelInterface $balances_show_view_model
	) {
		$this->balances_show_view_model = $balances_show_view_model;
	}

	public function show() {
		if ( !isset( $_GET['address'] ) ) {
			return;
		}
		$input_data = array(
			'address' => $_GET['address'],
		);
		$view_data = $this->balances_show_view_model->prepare( $input_data );
		return $view_data;
	}
}
