<?php

namespace Tokenly\Wp\Controllers\Web;

use Tokenly\Wp\Interfaces\Controllers\Web\PostControllerInterface;

use Tokenly\Wp\Interfaces\Presentation\Views\Web\PostAccessDeniedViewModelInterface;

/**
 * Serves the token meta views
 */
class PostController implements PostControllerInterface {

	public function __construct(
		PostAccessDeniedViewModelInterface $post_access_denied_view_model
	) {
		$this->post_access_denied_view_model = $post_access_denied_view_model;
	}

	public function denied() {
		$view_data = $this->post_access_denied_view_model->prepare();
		return array(
			'template' => 'Denied.twig',
			'data'     => $view_data,
		);
	}
}
