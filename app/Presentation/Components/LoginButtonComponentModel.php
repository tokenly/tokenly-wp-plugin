<?php

namespace Tokenly\Wp\Presentation\Components;

use Tokenly\Wp\Presentation\Components\ComponentModel;
use Tokenly\Wp\Interfaces\Presentation\Components\LoginButtonComponentModelInterface;
use Tokenly\Wp\Interfaces\Models\IntegrationInterface;

class LoginButtonComponentModel extends ComponentModel implements LoginButtonComponentModelInterface {
	protected $integration;
	protected $root_dir;
	protected $namespace;

	public function __construct(
		IntegrationInterface $integration,
		string $root_dir,
		string $namespace
	) {
		$this->root_dir = $root_dir;
		$this->namespace = $namespace;
		$this->integration = $integration;
	}

	public function render() {
		if ( $this->integration->can_connect() === false ) {
			return;
		}
		if ( is_user_logged_in() === true ) {
			return;
		}
		$logo = file_get_contents( $this->root_dir . '/resources/images/tokenly_logo.svg' );
		$url = "/{$this->namespace}/oauth/connect?{$this->namespace}_success_url=/wp-admin/admin.php?page=tokenly-connection";
		return array(
			'label' => 'Login with Tokenpass',
			'logo'  => $logo,
			'url'   => $url,
		);
	}
}
