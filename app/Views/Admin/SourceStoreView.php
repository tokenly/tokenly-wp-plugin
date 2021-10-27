<?php

namespace Tokenly\Wp\Views\Admin;

use Tokenly\Wp\Views\View;
use Twig\Environment;

class SourceStoreView extends View {
	public function __construct( Environment $twig ) {
		parent::__construct( $twig );
	}

	public function render( $data ) {
		$html = $this->twig->render( 'admin.twig', array(
			'view' => 'source-store',
		) );
		return $html;
	}
}


