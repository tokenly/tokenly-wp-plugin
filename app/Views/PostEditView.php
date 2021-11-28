<?php

namespace Tokenly\Wp\Views;

use Tokenly\Wp\Views\View;

class PostEditView extends View {
	public function render( $data ) {
		$html = $this->twig->render( 'Admin.twig', array(
			'view' => 'post-edit',
			'tca_enabled' => $data['tca_enabled'] ?? false,
			'tca_rules' => $data['tca_rules'] ?? array(),
		) );
		return $html;
	}
}
