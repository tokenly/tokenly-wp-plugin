<?php

namespace Tokenly\Wp\Controllers\Web\Admin;

use Tokenly\Wp\Interfaces\Controllers\Web\Admin\SettingsControllerInterface;
use Tokenly\Wp\Views\Admin\SettingsView;
use Tokenly\Wp\Interfaces\Models\SettingsInterface;

/**
 * Serves the admin settings view
 */
class SettingsController implements SettingsControllerInterface {
	public $settings_view;
	public $settings;

	public function __construct(
		SettingsView $settings_view,
		SettingsInterface $settings
	) {
		$this->settings_view = $settings_view;
		$this->settings = $settings;
	}

	public function show() {
		$render = $this->settings_view->render( array(
			'app_homepage_url' => get_site_url(),
			'client_auth_url'  => TOKENLY_PLUGIN_AUTH_REDIRECT_URI,
			'settings_data'    => $this->settings,
		) );
		echo $render;
	}
}
