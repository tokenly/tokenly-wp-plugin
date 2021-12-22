<?php

namespace Tokenly\Wp\Controllers\Api\Settings;

use Tokenly\Wp\Controllers\Api\SettingsController;
use Tokenly\Wp\Interfaces\Controllers\Api\Settings\IntegrationControllerInterface;

use Tokenly\Wp\Interfaces\Models\Settings\IntegrationSettingsInterface;

/**
 * Handles the Integration settings REST API endpoints
 */
class IntegrationController extends SettingsController implements IntegrationControllerInterface {
	public function __construct(
		IntegrationSettingsInterface $settings
	) {
		$this->settings = $settings;
	}
}
