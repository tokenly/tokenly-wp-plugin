<?php

namespace Tokenly\Wp\Controllers\Web\Admin;

use Tokenly\Wp\Routes\ApiRouter;

class SettingsController {
	public $api_router;

	public function __construct() {
		$this->api_router = new ApiRouter();
	}

	public function show() {
		$data = array();
		$app_homepage_url = 'https://';
		$app_homepage_url .= $_SERVER['HTTP_HOST'] . '/tokenly';
		$data['app_homepage_url'] = $app_homepage_url;
		$client_auth_url = $this->api_router->get_route_url( 'authorize-callback' );
		$data['client_auth_url'] = $client_auth_url;
		include TOKENLY_PLUGIN_DIR . 'resources/views/admin/settings.php';
	}
}
