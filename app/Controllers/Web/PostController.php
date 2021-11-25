<?php

namespace Tokenly\Wp\Controllers\Web;

use Tokenly\Wp\Views\PostEditView;
use Tokenly\Wp\Interfaces\Controllers\Web\PostControllerInterface;

/**
 * Serves the token meta views
 */
class PostController implements PostControllerInterface {
	public $post_edit_view;

	public function __construct(
		PostEditView $post_edit_view
	) {
		$this->post_edit_view = $post_edit_view;
	}
	
	/**
	 * Displays a section on Token Meta post edit screen.
	 * It is responsible for editing the additional token meta.
	 */
	public function edit() {
		$render = $this->post_edit_view->render( array(
			'meta' => $meta,
		) );
		return $render;
	}
}
