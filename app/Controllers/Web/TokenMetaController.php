<?php

namespace Tokenly\Wp\Controllers\Web;

use Tokenly\Wp\Views\TokenMetaEditView;
use Tokenly\Wp\Controllers\Web\WebController;

class TokenMetaController extends WebController {
	public $token_meta_edit_view;

	public function __construct( TokenMetaEditView $token_meta_edit_view ) {
		parent::__construct();
		$this->token_meta_edit_view = $token_meta_edit_view;
	}
	
	public function edit() {
		$render = $this->token_meta_edit_view->render( array(
			//
		) );
		echo $render;
	}
}
