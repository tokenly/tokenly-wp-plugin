<?php

namespace Tokenly\Wp\Controllers\Web;

use Tokenly\Wp\Views\PostEditView;
use Tokenly\Wp\Interfaces\Controllers\Web\PostControllerInterface;
use Tokenly\Wp\Interfaces\Services\Domain\PostServiceInterface;

/**
 * Serves the token meta views
 */
class PostController implements PostControllerInterface {
	protected $post_edit_view;
	protected $post_service;

	public function __construct(
		PostEditView $post_edit_view,
		PostServiceInterface $post_service
	) {
		$this->post_edit_view = $post_edit_view;
		$this->post_service = $post_service;
	}
	
	/**
	 * Displays a section on Token Meta post edit screen.
	 * It is responsible for editing the additional token meta.
	 */
	public function edit() {
		$post_id = get_the_ID();
		if ( !$post_id || $post_id == 0 ) {
			return;
		}
		$post = $this->post_service->show( array(
			'id' => $post_id,
		) );
		if ( !$post ) {
			return;
		}
		$post = $post->to_array();
		error_log( print_r( $post, true ) );
		$render = $this->post_edit_view->render( array(
			'post' => $post,
		) );
		return $render;
	}
}
