<?php

namespace Tokenly\Wp\Views\Admin;

use Tokenly\Wp\Views\View;

class DashboardView extends View {
	public function render( $data ) {
		$html = $this->twig->render( 'Admin.twig', array(
			'view' => 'dashboard',
			'props' => array( 
				'is_admin' => current_user_can( 'administrator' ),
			),
		) );
		return $html;
	}
}


