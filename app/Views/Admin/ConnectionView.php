<?php

namespace Tokenly\Wp\Views\Admin;

use Tokenly\Wp\Views\View;

class ConnectionView extends View {
	public function render( $data ) {
		$html = $this->twig->render( 'Admin.twig', array(
			'view' => 'connection',
			'props' => array(
				'status' => $data['status'] ?? null,
				'user'   => $data['user'] ?? null,
			),
		) );
		return $html;
	}
}
