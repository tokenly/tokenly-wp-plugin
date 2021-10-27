<?php

namespace Tokenly\Wp\Views;

use Tokenly\Wp\Views\View;
use Twig\Environment;

class TokenMetaEditView extends View {
	public function __construct( Environment $twig ) {
		parent::__construct( $twig );
	}

	public function render( $data ) {
		$html = $this->twig->render( 'admin.twig', array(
			'view' => 'token-meta-edit',
		) );
		return $html;
	}
}
