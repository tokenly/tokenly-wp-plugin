<?php

namespace Tokenly\Wp\Views\Admin;

use Tokenly\Wp\Views\View;

class CreditTransactionIndexView extends View {
	public function render( $data ) {
		$html = $this->twig->render( 'Admin.twig', array(
			'view'  => 'credit-transaction-index',
			'props' => array(
				'credit_transactions' => $data['credit_transactions'] ?? null,
			),
		) );
		return $html;
	}
}


