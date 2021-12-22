<?php

namespace Tokenly\Wp\Controllers\Web\Admin\Token;

use Tokenly\Wp\Interfaces\Controllers\Web\Admin\Token\BalanceControllerInterface;
use Tokenly\Wp\Interfaces\Presentation\Views\Admin\Token\BalanceIndexViewModelInterface;

/**
 * Serves the admin balance views
 */
class BalanceController implements BalanceControllerInterface {
	protected $index_view_model;

	public function __construct(
		BalanceIndexViewModelInterface $index_view_model
	) {
		$this->index_view_model = $index_view_model;
	}

	public function index() {
		$input_data = array();
		if ( isset( $_GET['address'] ) ) {
			$input_data['address'] = $_GET['address'];
		} elseif ( isset( $_GET['user'] ) ) {
			$input_data['user'] = $_GET['user'];
		} else {
			return false;
		}
		$view_data = $this->index_view_model->prepare( $input_data );
		return array(
			'view' => 'token-balance-show',
			'data' => $view_data,
		);
	}
}
