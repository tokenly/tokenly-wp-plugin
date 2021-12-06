<?php

namespace Tokenly\Wp\Controllers\Api\Settings;

use Tokenly\Wp\Controllers\Api\SettingsController;
use Tokenly\Wp\Interfaces\Controllers\Api\Settings\OauthSettingsControllerInterface;
use Tokenly\Wp\Interfaces\Models\Settings\OauthSettingsInterface;

/**
 * Handles the OAuth settings REST API endpoints
 */
class OauthSettingsController extends SettingsController implements OauthSettingsControllerInterface {
	public function __construct(
		OauthSettingsInterface $settings
	) {
		$this->settings = $settings;
	}
}
