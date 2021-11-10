<?php

namespace Tokenly\Wp\Views\Admin;

use Tokenly\Wp\Views\View;

class VendorView extends View {
	public function render( $data ) {
		$html = $this->twig->render( 'Admin.twig', array(
			'view'  => 'vendor',
			'props' => array(
				'promises' => $data['promises'] ?? null,
			)
		) );
		return $html;
	}
}


