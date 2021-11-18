<?php

namespace Tokenly\Wp\Views\Admin;

use Tokenly\Wp\Views\View;

class SettingsView extends View {
	public function render( $data ) {
		$html = $this->twig->render( 'Admin.twig', array(
			'view'  => 'settings',
			'props' => array( 
				'app_homepage_url' => $data['app_homepage_url'] ?? null,
				'client_auth_url'  => $data['client_auth_url'] ?? null,
				'settings_data'    => $data['settings_data'] ?? null,
			),
		) );
		return $html;
	}
}


