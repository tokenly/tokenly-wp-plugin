<?php

namespace Tokenly\Wp\Views;

use Tokenly\Wp\Views\View;

class TokenMetaEditView extends View {
	public function render( $data ) {
		$html = $this->twig->render( 'admin.twig', array(
			'view' => 'token-meta-edit',
			'props' => array(
				'meta' => $data['meta'] ?? null,
			),
		) );
		return $html;
	}
}
