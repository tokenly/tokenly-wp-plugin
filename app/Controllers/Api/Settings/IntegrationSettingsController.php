<?php

namespace Tokenly\Wp\Controllers\Api\Settings;

use Tokenly\Wp\Controllers\Api\SettingsController;
use Tokenly\Wp\Interfaces\Controllers\Api\Settings\IntegrationSettingsControllerInterface;
use Tokenly\Wp\Interfaces\Models\Settings\IntegrationSettingsInterface;

/**
 * Handles the Integration settings REST API endpoints
 */
class IntegrationSettingsController extends SettingsController implements IntegrationSettingsControllerInterface {
	public function __construct(
		IntegrationSettingsInterface $settings
	) {
		$this->settings = $settings;
	}
}
