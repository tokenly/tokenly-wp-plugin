<?php

namespace Tokenly\Wp\Views\Admin;

class SettingsView {
	public $app_homepage_url;
	public $client_auth_url;

	public function __construct( $data ) {
		$this->app_homepage_url = $data['app_homepage_url'] ?? null;
		$this->client_auth_url = $data['client_auth_url'] ?? null;
	}

	public function render() {
		$html = "
			<script>
				const appHomepageUrl = '{$this->app_homepage_url}';
				const clientAuthUrl = '{$this->client_auth_url}';
			</script>
			<div id='tokenpass-settings-page-content'></div>
		";
		return $html;
	}
}


