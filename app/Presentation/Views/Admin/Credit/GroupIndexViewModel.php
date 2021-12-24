<?php

namespace Tokenly\Wp\Presentation\Views\Admin\Credit;

use Tokenly\Wp\Presentation\Views\ViewModel;
use Tokenly\Wp\Interfaces\Presentation\Views\Admin\Credit\GroupIndexViewModelInterface;

use Tokenly\Wp\Interfaces\Services\Domain\Credit\GroupServiceInterface;

class GroupIndexViewModel extends ViewModel implements GroupIndexViewModelInterface {
	public function prepare( array $data = array() ) {
		return array();
	}
}
