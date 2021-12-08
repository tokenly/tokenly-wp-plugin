<?php

namespace Tokenly\Wp\Views\Admin;

use Tokenly\Wp\Views\View;

class CreditGroupStoreView extends View {
	public function render( $data = array() ) {
		$html = $this->twig->render( 'Admin.twig', array(
			'view'  => 'credit-group-store',
			'props' => array(),
		) );
		return $html;
	}
}
