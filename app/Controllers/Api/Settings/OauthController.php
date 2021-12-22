<?php

namespace Tokenly\Wp\Controllers\Api\Settings;

use Tokenly\Wp\Controllers\Api\SettingsController;
use Tokenly\Wp\Interfaces\Controllers\Api\Settings\OauthControllerInterface;

use Tokenly\Wp\Interfaces\Models\Settings\OauthSettingsInterface;

/**
 * Handles the OAuth settings REST API endpoints
 */
class OauthController extends SettingsController implements OauthControllerInterface {
	public function __construct(
		OauthSettingsInterface $settings
	) {
		$this->settings = $settings;
	}
}
