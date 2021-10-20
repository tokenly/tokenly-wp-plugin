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
		$render = $this->settings_view->render( array(
			'app_homepage_url' => get_site_url(),
			'client_auth_url'  => TOKENLY_PLUGIN_AUTH_REDIRECT_URI,
		) );
		echo $render;
	}
}
