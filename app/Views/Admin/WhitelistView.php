<?php

namespace Tokenly\Wp\Views\Admin;

use Tokenly\Wp\Views\View;

class WhitelistView extends View {
	public function render( $data ) {
		$html = $this->twig->render( 'admin.twig', array(
			'view' => 'whitelist',
		) );
		return $html;
	}
}


