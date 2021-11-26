<?php

namespace Tokenly\Wp\Controllers\Web;

use Tokenly\Wp\Views\TokenMetaEditView;
use Tokenly\Wp\Interfaces\Services\Domain\TokenMetaServiceInterface;
use Tokenly\Wp\Interfaces\Controllers\Web\TokenMetaControllerInterface;

/**
 * Serves the token meta views
 */
class TokenMetaController implements TokenMetaControllerInterface {
	public $token_meta_edit_view;
	public $token_meta_repository;

	public function __construct(
		TokenMetaEditView $token_meta_edit_view,
		TokenMetaServiceInterface $token_meta_service
	) {
		$this->token_meta_edit_view = $token_meta_edit_view;
		$this->token_meta_service = $token_meta_service;
	}
	
	/**
	 * Displays a section on Token Meta post edit screen.
	 * It is responsible for editing the additional token meta.
	 */
	public function edit() {
		$meta = $this->token_meta_service->show( array( 'id' => get_the_ID() ) );
		if ( $meta ) {
			$meta = $meta->to_array();
		}
		$render = $this->token_meta_edit_view->render( array(
			'meta' => $meta,
		) );
		return $render;
	}
}
