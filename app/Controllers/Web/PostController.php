<?php

namespace Tokenly\Wp\Controllers\Web;

use Tokenly\Wp\Interfaces\Controllers\Web\PostControllerInterface;
use Tokenly\Wp\Interfaces\Presentation\Views\Admin\PostEditViewModelInterface;
use Tokenly\Wp\Interfaces\Presentation\Views\Web\PostAccessDeniedViewModelInterface;

/**
 * Serves the token meta views
 */
class PostController implements PostControllerInterface {
	protected $post_edit_view_model;

	public function __construct(
		PostEditViewModelInterface $post_edit_view_model,
		PostAccessDeniedViewModelInterface $post_access_denied_view_model
	) {
		$this->post_edit_view_model = $post_edit_view_model;
		$this->post_access_denied_view_model = $post_access_denied_view_model;
	}
	
	/**
	 * Displays a section on Token Meta post edit screen.
	 * It is responsible for editing the additional token meta.
	 */
	public function edit() {
		$view_data = $this->post_edit_view_model->prepare();
		return array(
			'template' => 'Dynamic.twig',
			'view'     => 'post-edit',
			'data'     => $view_data,
		);
	}

	public function denied() {
		$view_data = $this->post_access_denied_view_model->prepare();
		return array(
			'template' => 'Denied.twig',
			'data'     => $view_data,
		);
	}
}
