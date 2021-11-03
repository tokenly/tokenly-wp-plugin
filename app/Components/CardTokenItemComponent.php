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
		$asset = $balance['asset'] ?? null;
		$balance = $balance['balance'] ?? null;
		$description = '';
		$extra = '';
		$image = '';
		if ( $meta ) {
			$name_meta = $meta['name'];
			if ( $name_meta ) {
				$name = $name_meta;
			}
			$description = $meta['description'] ?? null;
			$image = $meta['image'] ?? null;
			$extra = $meta['extra'] ?? null;
			if ( $extra ) {
				$extra = wp_unslash( json_encode( $extra, JSON_PRETTY_PRINT ) );
			}
		} 
		$html = $this->twig->render( 'components/CardTokenItemComponent.twig', array(
			'asset'       => $asset,
			'name'        => $name,
			'description' => $description,
			'image'       => $image,
			'balance'     => $balance,
			'extra'       => $extra,
		) );
		return $html;
	}
}
