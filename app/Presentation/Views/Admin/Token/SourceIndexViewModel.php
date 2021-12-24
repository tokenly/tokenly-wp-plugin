<?php

namespace Tokenly\Wp\Presentation\Views\Admin\Token;

use Tokenly\Wp\Presentation\Views\ViewModel;
use Tokenly\Wp\Interfaces\Presentation\Views\Admin\Token\SourceIndexViewModelInterface;

class SourceIndexViewModel extends ViewModel implements SourceIndexViewModelInterface {
	public function prepare( array $data = array() ) {
		return array();
	}
}
