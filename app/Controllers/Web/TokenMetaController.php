<?php

namespace Tokenly\Wp\Controllers\Web;

use Tokenly\Wp\Interfaces\Controllers\Web\TokenMetaControllerInterface;
use Tokenly\Wp\Interfaces\Presentation\Views\Admin\TokenMetaEditViewModelInterface;

/**
 * Serves the token meta views
 */
class TokenMetaController implements TokenMetaControllerInterface {
	public $token_meta_edit_view_model;

	public function __construct(
		TokenMetaEditViewModelInterface $token_meta_edit_view_model
	) {
		$this->token_meta_edit_view_model = $token_meta_edit_view_model;
	}
	
	/**
	 * Displays a section on Token Meta post edit screen.
	 * It is responsible for editing the additional token meta.
	 */
	public function edit() {
		$view_data = $this->token_meta_edit_view_model->prepare();
		return array(
			'template' => 'Dynamic.twig',
			'view'     => 'token-meta-edit',
			'data'     => $view_data,
		);
	}
}
