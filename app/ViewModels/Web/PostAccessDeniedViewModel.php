<?php

namespace Tokenly\Wp\ViewModels\Web;

class PostAccessDeniedViewModel {
	public function prepare( array $data = array() ) {
		return array(
			'back_url' => $_SERVER['HTTP_REFERER'] ?? '/',
		);
	}
}
