<?php

namespace Tokenly\Wp\Views\Admin;

use Tokenly\Wp\Views\View;

class SourceStoreView extends View {
	public function render( $data ) {
		$html = $this->twig->render( 'Admin.twig', array(
			'view' => 'source-store',
		) );
		return $html;
	}
}
