<?php

namespace Tokenly\Wp\Views;

use Tokenly\Wp\Views\WebView;

class PostAccessDeniedView extends WebView {
	protected $name = 'denied';

	public function render_content( array $data = array() ) {
		$html = $this->twig->render( 'Denied.twig', array(
			'back_url' => $_SERVER['HTTP_REFERER'] ?? '/',
		) );
		return $html;
	}
}
