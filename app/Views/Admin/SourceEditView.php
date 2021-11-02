<?php

namespace Tokenly\Wp\Views\Admin;

use Tokenly\Wp\Views\View;

class SourceEditView extends View {
	public function render( $data ) {
		$html = $this->twig->render( 'Admin.twig', array(
			'view' => 'source-edit',
			'props' => array(
				'source' => $data['source'] ?? null,
			)
		) );
		return $html;
	}
}
