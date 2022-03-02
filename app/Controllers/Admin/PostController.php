<?php

namespace Tokenly\Wp\Controllers\Admin;

use Tokenly\Wp\Interfaces\Controllers\Admin\PostControllerInterface;

use Tokenly\Wp\Interfaces\Presentation\Views\Admin\PostEditViewModelInterface;
use Tokenly\Wp\Interfaces\Models\PostInterface;

/**
 * Serves the admin Connection view
 */
class PostController implements PostControllerInterface {
	protected PostEditViewModelInterface $post_edit_view_model;

	public function __construct(
		PostEditViewModelInterface $post_edit_view_model
	) {
		$this->post_edit_view_model = $post_edit_view_model;
	}

	public function edit( PostInterface $post ): array {
		$input_data = array(
			'post' => $post,
		);
		$view_data = $this->post_edit_view_model->prepare( $input_data );
		return array(
			'view' => 'post-edit',
			'data' => $view_data,
		);
	}
}
