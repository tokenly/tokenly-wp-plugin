<?php

namespace Tokenly\Wp\Views\Admin;

use Tokenly\Wp\Views\View;

class SettingsView extends View {
	public function render( $data ) {
		$html = $this->twig->render( 'Admin.twig', array(
			'view'  => 'settings',
			'props' => array( 
				'integration_data'     => $data['integration_data'] ?? array(),
				'integration_settings' => $data['integration_settings'] ?? array(),
			),
		) );
		return $html;
	}
}


