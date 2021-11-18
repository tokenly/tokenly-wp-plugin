<?php

namespace Tokenly\Wp\Views\Admin;

use Tokenly\Wp\Views\View;

class PromiseStoreView extends View {
	public function render( $data ) {
		$html = $this->twig->render( 'Admin.twig', array(
			'view'  => 'promise-store',
			'props' => array(
				'sources' => $data['sources'] ?? null,
			),
		) );
		return $html;
	}
}


