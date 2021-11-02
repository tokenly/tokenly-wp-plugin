<?php

namespace Tokenly\Wp\Views\Admin;

use Tokenly\Wp\Views\View;

class SourceIndexView extends View {
	public function render( $data ) {
		$html = $this->twig->render( 'Admin.twig', array(
			'view'  => 'source-index',
			'props' => array(
				'sources' => $data['sources'] ?? null,
			),
		) );
		return $html;
	}
}


