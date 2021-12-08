<?php

namespace Tokenly\Wp\Views\Admin;

use Tokenly\Wp\Views\View;

class CreditGroupIndexView extends View {
	public function render( $data ) {
		$html = $this->twig->render( 'Admin.twig', array(
			'view'  => 'credit-group-index',
			'props' => array(
				'credit_groups' => $data['credit_groups'] ?? null,
			),
		) );
		return $html;
	}
}


