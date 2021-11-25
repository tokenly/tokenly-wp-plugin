<?php

namespace Tokenly\Wp\Views;

use Tokenly\Wp\Views\View;

class PostEditView extends View {
	public function render( $data ) {
		$html = $this->twig->render( 'Admin.twig', array(
			'view' => 'post-edit',
			'use_tca' => $data['use_tca'] ?? false,
		) );
		return $html;
	}
}
