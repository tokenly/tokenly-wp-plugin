<?php

namespace Tokenly\Wp\Views\Admin;

use Tokenly\Wp\Views\View;

class BalancesShowView extends View {
	public function render( $data ) {
		$html = $this->twig->render( 'Admin.twig', array(
			'view'  => 'balances-show',
			'props' => array(
				'address' => $data['address'] ?? null,
			),
		) );
		return $html;
	}
}


