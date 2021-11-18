<?php

namespace Tokenly\Wp\Views\Admin;

use Tokenly\Wp\Views\View;

class PromiseEditView extends View {
	public function render( $data ) {
		$html = $this->twig->render( 'Admin.twig', array(
			'view'  => 'promise-edit',
			'props' => array(
				'promise' => $data['promise'] ?? null,
			),
		) );
		return $html;
	}
}


