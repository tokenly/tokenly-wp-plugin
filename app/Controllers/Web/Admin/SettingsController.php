<?php

namespace Tokenly\Wp\Controllers\Web\Admin;

use Tokenly\Wp\Interfaces\Controllers\Web\Admin\SettingsControllerInterface;
use Tokenly\Wp\ViewModels\Admin\SettingsViewModel;

/**
 * Serves the admin settings view
 */
class SettingsController implements SettingsControllerInterface {
	protected $settings_view_model;

	public function __construct(
		SettingsViewModel $settings_view_model
	) {
		$this->settings_view_model = $settings_view_model;
	}

	public function show() {
		$view_data = $this->settings_view_model->prepare();
		return $view_data;
	}
}
