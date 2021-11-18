<?php

namespace Tokenly\Wp\Controllers\Web\Admin;

use Tokenly\Wp\Interfaces\Controllers\Web\Admin\SettingsControllerInterface;
use Tokenly\Wp\Views\Admin\SettingsView;
use Tokenly\Wp\Interfaces\Models\IntegrationInterface;

/**
 * Serves the admin settings view
 */
class SettingsController implements SettingsControllerInterface {
	protected $settings_view;
	protected $integration;

	public function __construct(
		SettingsView $settings_view,
		IntegrationInterface $integration
	) {
		$this->settings_view = $settings_view;
		$this->integration = $integration;
	}

	public function show() {
		$integration_settings = $this->integration->settings->to_array();
		$render = $this->settings_view->render( array(
			'integration_settings' => $integration_settings,
			'integration_data'     => array(
				'app_homepage_url'  => get_site_url(),
				'client_auth_url'   => TOKENLY_PLUGIN_AUTH_REDIRECT_URI,
				'status'            => $this->integration->can_connect(),
			),
		) );
		echo $render;
	}
}
