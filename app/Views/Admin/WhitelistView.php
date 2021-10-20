<?php

namespace Tokenly\Wp\Views\Admin;

use Tokenly\Wp\Views\View;
use Twig\Environment;

class WhitelistView extends View {
	public function __construct( Environment $twig ) {
		parent::__construct( $twig );
	}

	public function render( $data ) {
		$html = $this->twig->render( 'admin/whitelist.html', array(
			//
		) );
		return $html;
	}
}


