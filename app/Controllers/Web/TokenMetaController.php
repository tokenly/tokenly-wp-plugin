<?php

namespace Tokenly\Wp\Controllers\Web;

use Tokenly\Wp\Views\TokenMetaEditView;
use Tokenly\Wp\Controllers\Web\WebController;
use Tokenly\Wp\Repositories\Post\TokenMetaRepository;

class TokenMetaController extends WebController {
	public $token_meta_edit_view;
	public $token_meta_repository;

	public function __construct(
		TokenMetaEditView $token_meta_edit_view,
		TokenMetaRepository $token_meta_repository
	) {
		parent::__construct();
		$this->token_meta_edit_view = $token_meta_edit_view;
		$this->token_meta_repository = $token_meta_repository;
	}
	
	public function edit() {
		$render = $this->token_meta_edit_view->render( array(
			'props' => $this->token_meta_repository->show( get_the_ID() ),
		) );
		echo $render;
	}
}
