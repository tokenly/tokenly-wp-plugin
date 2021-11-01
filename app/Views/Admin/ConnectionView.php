<?php

namespace Tokenly\Wp\Views\Admin;

use Tokenly\Wp\Views\View;

class ConnectionView extends View {
	public function render( $data ) {
		$html = $this->twig->render( 'admin.twig', array(
			'view' => 'connection',
		) );
		return $html;
	}
}
