<?php

namespace Tokenly\Wp\Controllers\Api;

use Tokenly\Wp\Interfaces\Controllers\Api\SettingsControllerInterface;

/**
 * Handles the integration settings REST API endpoints
 */
class SettingsController implements SettingsControllerInterface {
	protected $settings;
	
	/**
	 * Responds with the settings
	 * @param \WP_REST_Request $request Request data
	 * @return array
	 */
	public function show( \WP_REST_Request $request ) {
		return $this->settings->to_array(); 
	}

	/**
	 * Updates the settings
	 * @param \WP_REST_Request $request Request data
	 * @return array
	 */
	public function update( \WP_REST_Request $request ) {
		d('update');
		$params = $request->get_params();
		$this->settings->update( $params );
		return array(
			'status' => 'Settings were updated successfully.',
		);
	}
}
