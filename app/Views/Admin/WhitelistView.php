<?php

namespace Tokenly\Wp\Views\Admin;

use Tokenly\Wp\Views\View;

class WhitelistView extends View {
	public function render( $data ) {
		$html = $this->twig->render( 'Admin.twig', array(
			'view' => 'whitelist',
			'props' => array(
				'whitelist' => $data['whitelist'] ?? null,
			),
		) );
		return $html;
	}
}


