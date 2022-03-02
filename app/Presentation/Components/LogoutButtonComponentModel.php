<?php

namespace Tokenly\Wp\Presentation\Components;

use Tokenly\Wp\Presentation\Components\ComponentModel;
use Tokenly\Wp\Interfaces\Presentation\Components\LogoutButtonComponentModelInterface;

class LogoutButtonComponentModel extends ComponentModel implements LogoutButtonComponentModelInterface {
	protected string $root_dir;
	protected string $namespace;
	
	public function __construct(
		string $root_dir,
		string $namespace
	) {
		$this->root_dir = $root_dir;
		$this->namespace = $namespace;
	}

	/**
	 * @inheritDoc
	 */
	public function prepare( array $data = array() ): array {
		$can_connect = $this->integration->can_connect();
		$is_logged_in = is_user_logged_in();
		$logo = file_get_contents( $this->root_dir . '/resources/images/tokenly_logo.svg' );
		return array(
			'label' => 'Logout',
			'logo'  => $logo,
			'url'   => wp_logout_url(),
			'can_connect'  => $can_connect,
			'is_logged_in' => $is_logged_in,
			'namespace'    => $this->namespace,
		);
	}
}
