<?php

namespace Tokenly\Wp\Controllers\Api;

use Tokenly\Wp\Interfaces\Controllers\Api\SettingsControllerInterface;

use Tokenly\Wp\Interfaces\Models\Settings\IntegrationSettingsInterface;
use Tokenly\Wp\Interfaces\Models\Settings\OauthSettingsInterface;
use Tokenly\Wp\Interfaces\Models\Settings\TcaSettingsInterface;
use Tokenly\Wp\Interfaces\Models\Settings\WhitelistSettingsInterface;

/**
 * Handles the integration settings REST API endpoints
 */
class SettingsController implements SettingsControllerInterface {
	protected $settings;

	public function __construct(
		IntegrationSettingsInterface $integration_settings,
		OauthSettingsInterface $oauth_settings,
		TcaSettingsInterface $tca_settings,
		WhitelistSettingsInterface $token_whitelist_settings
	) {
		$this->settings = array(
			'integration'       => $integration_settings,
			'oauth'             => $oauth_settings,
			'tca'               => $tca_settings,
			'token_whitelist'   => $token_whitelist_settings,
		);
	}

	public function show_integration( \WP_REST_Request $request ) {
		return $this->show( 'integration', $request );
	}

	public function show_oauth( \WP_REST_Request $request ) {
		return $this->show( 'oauth', $request );
	}

	public function show_tca( \WP_REST_Request $request ) {
		return $this->show( 'tca', $request );
	}

	public function show_whitelist( \WP_REST_Request $request ) {
		return $this->show( 'token_whitelist', $request );
	}

	public function update_integration( \WP_REST_Request $request ) {
		return $this->update( 'integration', $request );
	}

	public function update_oauth( \WP_REST_Request $request ) {
		return $this->update( 'oauth', $request );
	}

	public function update_tca( \WP_REST_Request $request ) {
		return $this->update( 'tca', $request );
	}

	public function update_token_whitelist( \WP_REST_Request $request ) {
		return $this->update( 'token_whitelist', $request );
	}

	protected function show( string $type, \WP_REST_Request $request ) {
		return $this->settings[ $type ]->to_array(); 
	}

	protected function update( string $type, \WP_REST_Request $request ) {
		$params = $request->get_params();
		$this->settings[ $type ]->update( $params );
		return array(
			'status' => 'Settings were updated successfully.',
		);
	}
}
