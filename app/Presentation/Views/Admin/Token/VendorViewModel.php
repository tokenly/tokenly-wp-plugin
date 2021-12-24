<?php

namespace Tokenly\Wp\Presentation\Views\Admin\Token;

use Tokenly\Wp\Presentation\Views\ViewModel;
use Tokenly\Wp\Interfaces\Presentation\Views\Admin\Token\VendorViewModelInterface;

class VendorViewModel extends ViewModel implements VendorViewModelInterface {
	public function prepare( array $data = array() ) {
		return array();
	}
}
