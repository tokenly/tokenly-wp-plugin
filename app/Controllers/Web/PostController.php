<?php

namespace Tokenly\Wp\Controllers\Web;

use Tokenly\Wp\Interfaces\Controllers\Web\PostControllerInterface;
use Tokenly\Wp\ViewModels\Admin\PostEditViewModel;
use Tokenly\Wp\ViewModels\Web\PostAccessDeniedViewModel;

/**
 * Serves the token meta views
 */
class PostController implements PostControllerInterface {
	protected $post_edit_view_model;

	public function __construct(
		PostEditViewModel $post_edit_view_model,
		PostAccessDeniedViewModel $post_access_denied_view_model
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
