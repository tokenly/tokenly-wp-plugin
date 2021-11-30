<?php

namespace Tokenly\Wp\Controllers\Web;

use Tokenly\Wp\Views\PostEditView;
use Tokenly\Wp\Views\PostAccessDeniedView;
use Tokenly\Wp\Interfaces\Controllers\Web\PostControllerInterface;
use Tokenly\Wp\Interfaces\Services\Domain\PostServiceInterface;
use Tokenly\Wp\Interfaces\Models\TcaSettingsInterface;

/**
 * Serves the token meta views
 */
class PostController implements PostControllerInterface {
	protected $post_edit_view;
	protected $post_access_denied_view;
	protected $post_service;
	protected $tca_settings;

	public function __construct(
		PostEditView $post_edit_view,
		PostAccessDeniedView $post_access_denied_view,
		PostServiceInterface $post_service,
		TcaSettingsInterface $tca_settings
	) {
		$this->post_edit_view = $post_edit_view;
		$this->post_access_denied_view = $post_access_denied_view;
		$this->post_service = $post_service;
		$this->tca_settings = $tca_settings;
	}
	
	/**
	 * Displays a section on Token Meta post edit screen.
	 * It is responsible for editing the additional token meta.
	 */
	public function edit() {
		$post_type = get_post_type();
		$tca_enabled = $this->tca_settings->is_enabled_for_post_type( $post_type );
		$post_id = get_the_ID();
		if ( !$post_id || $post_id == 0 ) {
			return;
		}
		$post = $this->post_service->show( array(
			'id' => $post_id,
		) );
		$tca_rules = array();
		if ( $post ) {
			$tca_rules = $post->get_tca_rules();
			$tca_rules = $tca_rules->to_array();
		}
		$render = $this->post_edit_view->render( array(
			'tca_enabled' => $tca_enabled,
			'tca_rules'   => $tca_rules,
		) );
		return $render;
	}

	public function denied() {
		$render = $this->post_access_denied_view->render( array(
			//
		) );
		return $render;
	}
}
