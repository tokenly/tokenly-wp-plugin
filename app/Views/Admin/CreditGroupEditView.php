<?php

namespace Tokenly\Wp\Views\Admin;

use Tokenly\Wp\Views\View;

class CreditGroupEditView extends View {
	public function render( $data ) {
		$html = $this->twig->render( 'Admin.twig', array(
			'view' => 'credit-group-edit',
			'props' => array(
				'credit_group' => $data['credit_group'] ?? null,
			)
		) );
		return $html;
	}
}
