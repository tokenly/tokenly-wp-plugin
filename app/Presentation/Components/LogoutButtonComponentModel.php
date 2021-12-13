<?php

namespace Tokenly\Wp\Presentation\Components;

use Tokenly\Wp\Presentation\Components\ComponentModel;
use Tokenly\Wp\Interfaces\Presentation\Components\LogoutButtonComponentModelInterface;
use Tokenly\Wp\Interfaces\Models\IntegrationInterface;

class LogoutButtonComponentModel extends ComponentModel implements LogoutButtonComponentModelInterface {
	protected $settings;
	protected $root_dir;
	
	public function __construct(
		IntegrationInterface $integration,
		string $root_dir
	) {
		$this->root_dir = $root_dir;
		$this->integration = $integration;
	}

	public function prepare( array $data = array() ) {
		$can_connect = $this->integration->can_connect();
		$is_logged_in = is_user_logged_in();
		$logo = file_get_contents( $this->root_dir . '/resources/images/tokenly_logo.svg' );
		return array(
			'label' => 'Logout',
			'logo'  => $logo,
			'url'   => wp_logout_url(),
			'can_connect'  => $can_connect,
			'is_logged_in' => $is_logged_in,
		);
	}
}
