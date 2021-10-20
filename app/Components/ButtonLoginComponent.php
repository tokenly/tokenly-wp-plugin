<?php

namespace Tokenly\Wp\Components;

use Tokenly\Wp\Components\Component;
use Twig\Environment;

class ButtonLoginComponent extends Component {
	public function __construct( Environment $twig ) {
		parent::__construct( $twig );
	}

	public function render() {
		global $tokenly_routes;
		$api_routes = $tokenly_routes['api'];
		$url;
		if ( $api_routes ) {
			$url = $api_routes['authorize'] ?? null;
		}
		$html = $this->twig->render( 'components/ButtonLoginComponent.html', array(
			'url' => $url,
		) );
		return $html;
	}
}