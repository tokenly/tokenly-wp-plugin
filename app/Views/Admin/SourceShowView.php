<?php

namespace Tokenly\Wp\Views\Admin;

use Tokenly\Wp\Views\View;

class SourceShowView extends View {
	public function render( $data ) {
		$html = $this->twig->render( 'Admin.twig', array(
			'view'  => 'source-show',
			'props' => array(
				'source' => $data['source'] ?? null,
			),
		) );
		return $html;
	}
}


