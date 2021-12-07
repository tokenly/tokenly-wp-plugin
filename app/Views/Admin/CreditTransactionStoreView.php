<?php

namespace Tokenly\Wp\Views\Admin;

use Tokenly\Wp\Views\View;

class CreditTransactionStoreView extends View {
	public function render( $data = array() ) {
		$html = $this->twig->render( 'Admin.twig', array(
			'view'  => 'credit-transaction-store',
			'props' => array(
				'credit_groups' => $data['credit_groups'] ?? null,
			),
		) );
		return $html;
	}
}
