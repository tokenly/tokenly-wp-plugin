<?php

namespace Tokenly\Wp\Controllers\Api\Settings;

use Tokenly\Wp\Controllers\Api\SettingsController;
use Tokenly\Wp\Interfaces\Controllers\Api\Settings\TcaControllerInterface;

use Tokenly\Wp\Interfaces\Models\Settings\TcaSettingsInterface;

/**
 * Handles the TCA settings REST API endpoints
 */
class TcaController extends SettingsController implements TcaControllerInterface {
	public function __construct(
		TcaSettingsInterface $settings
	) {
		$this->settings = $settings;
	}
}
