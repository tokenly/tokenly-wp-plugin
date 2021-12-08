<?php

namespace Tokenly\Wp\Components;

use Tokenly\Wp\Components\Component;
use Tokenly\Wp\Interfaces\Components\CardAppCreditItemComponentInterface;

class CardAppCreditItemComponent extends Component implements CardAppCreditItemComponentInterface {	

	public function render( $data ) {
		$name = null;
		$balance = null;
		if ( isset( $data['name'] ) ) {
			$name = $data['name'];
		}
		if ( isset( $data['balance'] ) ) {
			$balance = $data['balance'];
		}
		$html = $this->twig->render( 'components/CardAppCreditItemComponent.twig', array(
			'name'   => $name,
			'balance' => $balance,
		) );
		return $html;
	}
}
