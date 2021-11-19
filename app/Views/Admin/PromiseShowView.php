<?php

namespace Tokenly\Wp\Views\Admin;

use Tokenly\Wp\Views\View;

class PromiseShowView extends View {
	public function render( $data ) {
		$html = $this->twig->render( 'Admin.twig', array(
			'view'  => 'promise-show',
			'props' => array(
				'promise' => $data['promise'] ?? null,
				'sources' => $data['sources'] ?? null,
			),
		) );
		return $html;
	}
}


