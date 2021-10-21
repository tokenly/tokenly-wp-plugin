<?php

namespace Tokenly\Wp\Components;

use Tokenly\Wp\Components\Component;
use Twig\Environment;

class CardTokenItemComponent extends Component {	
	public function __construct( Environment $twig ) {
		parent::__construct( $twig );
	}

	public function render( $data ) {
		$balance = $data['balance'] ?? null;
		$html = $this->twig->render( 'components/CardTokenItemComponent.twig', array(
			'name'    => $balance['name'] ?? null,
			'balance' => $balance['balance'] ?? null,
		) );
		return $html;
	}
}