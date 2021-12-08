<?php

namespace Tokenly\Wp\Controllers\Api\Settings;

use Tokenly\Wp\Controllers\Api\SettingsController;
use Tokenly\Wp\Interfaces\Controllers\Api\Settings\WhitelistSettingsControllerInterface;
use Tokenly\Wp\Interfaces\Models\Settings\WhitelistSettingsInterface;

/**
 * Handles the Whitelist settings REST API endpoints
 */
class WhitelistSettingsController extends SettingsController implements WhitelistSettingsControllerInterface {
	public function __construct(
		WhitelistSettingsInterface $settings
	) {
		$this->settings = $settings;
	}
}
