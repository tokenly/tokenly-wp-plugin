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
		$meta = $balance['meta'] ?? null;
		$name = $balance['name'] ?? null;
		$balance = $balance['balance'] ?? null;
		$description = '';
		$image = '';
		if ( $meta ) {
			$name_meta = $meta['name'];
			if ( $name_meta ) {
				$name = $name_meta;
			}
			$description = $meta['description'] ?? null;
			$image = $meta['image'] ?? null;
		} 
		$html = $this->twig->render( 'components/CardTokenItemComponent.twig', array(
			'name'        => $name,
			'description' => $description,
			'image'       => $image,
			'balance'     => $balance,
		) );
		return $html;
	}
}
