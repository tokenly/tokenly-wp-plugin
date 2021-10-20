<?php

namespace Tokenly\Wp\Views\Admin;

use Tokenly\Wp\Views\View;
use Twig\Environment;

class SettingsView extends View {
	public $app_homepage_url;
	public $client_auth_url;

	public function __construct( Environment $twig ) {
		parent::__construct( $twig );
	}

	public function render( $data ) {
		$this->app_homepage_url = $data['app_homepage_url'] ?? null;
		$this->client_auth_url = $data['client_auth_url'] ?? null;
		$html = $this->twig->render( 'admin/settings.html', array(
			'app_homepage_url' => $this->app_homepage_url,
			'client_auth_url' => $this->client_auth_url,
		) );
		return $html;
	}
}


