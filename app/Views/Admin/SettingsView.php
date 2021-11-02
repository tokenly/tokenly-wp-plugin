<?php

namespace Tokenly\Wp\Views\Admin;

use Tokenly\Wp\Views\View;

class SettingsView extends View {
	public function render( $data ) {
		$app_homepage_url = $data['app_homepage_url'] ?? null;
		$client_auth_url = $data['client_auth_url'] ?? null;
		$html = $this->twig->render( 'Admin.twig', array(
			'view'  => 'settings',
			'props' => array( 
				'app_homepage_url' => $app_homepage_url,
				'client_auth_url'  => $client_auth_url,
			),
		) );
		return $html;
	}
}


