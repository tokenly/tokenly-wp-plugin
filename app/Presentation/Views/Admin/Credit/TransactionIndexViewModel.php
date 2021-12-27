<?php

namespace Tokenly\Wp\Presentation\Views\Admin\Credit;

use Tokenly\Wp\Presentation\Views\ViewModel;
use Tokenly\Wp\Interfaces\Presentation\Views\Admin\Credit\TransactionIndexViewModelInterface;

class TransactionIndexViewModel extends ViewModel implements TransactionIndexViewModelInterface {
	public function prepare( array $data = array() ) {
		return array();
	}
}
