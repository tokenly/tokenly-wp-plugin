<?php

namespace Tokenly\Wp\Controllers\Web\Admin;

use Tokenly\Wp\Views\Admin\SettingsView;
use Tokenly\Wp\Controllers\Web\WebController;

class SettingsController extends WebController {
	public $settings_view;

	public function __construct( SettingsView $settings_view ) {
		$this->settings_view = $settings_view;
	}

	public function show() {
		$data = array();
		$app_homepage_url = 'https://';
		$app_homepage_url .= $_SERVER['HTTP_HOST'] . '/tokenly';
		global $tokenly_routes;
		$api_routes = $tokenly_routes['api'] ?? null;
		if ( !$api_routes ) {
			return;
		}
		$client_auth_url = $api_routes['authorize-callback'] ?? null;
		$render = $this->settings_view->render( array(
			'app_homepage_url' => $app_homepage_url,
			'client_auth_url'  => $client_auth_url,
		) );
		echo $render;
	}
}
