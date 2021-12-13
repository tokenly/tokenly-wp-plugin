<?php

namespace Tokenly\Wp\Presentation\Views\Web;

use Tokenly\Wp\Presentation\Views\ViewModel;
use Tokenly\Wp\Interfaces\Presentation\Views\Web\PostAccessDeniedViewModelInterface;

class PostAccessDeniedViewModel extends ViewModel implements PostAccessDeniedViewModelInterface {
	public function prepare( array $data = array() ) {
		return array(
			'back_url' => $_SERVER['HTTP_REFERER'] ?? '/',
		);
	}
}
