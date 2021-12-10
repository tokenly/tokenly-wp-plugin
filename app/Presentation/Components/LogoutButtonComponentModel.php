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

	public function render() {
		if ( $this->integration->can_connect() === false ) {
			return;
		}
		if ( is_user_logged_in() === false ) {
			return;
		}
		$logo = file_get_contents( $this->root_dir . '/resources/images/tokenly_logo.svg' );
		return array(
			'label' => 'Logout',
			'logo'  => $logo,
			'url'   => wp_logout_url(),
		);
	}
}
