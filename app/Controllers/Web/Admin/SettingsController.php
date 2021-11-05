<?php

namespace Tokenly\Wp\Controllers\Web\Admin;

use Tokenly\Wp\Interfaces\Controllers\Web\Admin\SettingsControllerInterface;
use Tokenly\Wp\Interfaces\Repositories\SettingsRepositoryInterface;
use Tokenly\Wp\Views\Admin\SettingsView;

/**
 * Serves the admin settings view
 */
class SettingsController implements SettingsControllerInterface {
	public $settings_view;
	public $settings_repository;

	public function __construct(
		SettingsRepositoryInterface $settings_repository,
		SettingsView $settings_view
	) {
		$this->settings_repository = $settings_repository;
		$this->settings_view = $settings_view;
	}

	public function show() {
		$settings_data = $this->settings_repository->show();
		$render = $this->settings_view->render( array(
			'app_homepage_url' => get_site_url(),
			'client_auth_url'  => TOKENLY_PLUGIN_AUTH_REDIRECT_URI,
			'settings_data'    => $settings_data,
		) );
		echo $render;
	}
}
