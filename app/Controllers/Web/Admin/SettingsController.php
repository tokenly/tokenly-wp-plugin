<?php

namespace Tokenly\Wp\Controllers\Web\Admin;

use Tokenly\Wp\Interfaces\Controllers\Web\Admin\SettingsControllerInterface;
use Tokenly\Wp\Interfaces\Presentation\Views\Admin\SettingsViewModelInterface;

/**
 * Serves the admin settings view
 */
class SettingsController implements SettingsControllerInterface {
	protected $settings_view_model;

	public function __construct(
		SettingsViewModelInterface $settings_view_model
	) {
		$this->settings_view_model = $settings_view_model;
	}

	public function show() {
		$view_data = $this->settings_view_model->prepare();
		return array(
			'view' => 'settings',
			'data' => $view_data,
		);
	}
}
