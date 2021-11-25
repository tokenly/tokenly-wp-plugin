<?php

namespace Tokenly\Wp\Controllers\Api;

use Tokenly\Wp\Interfaces\Controllers\Api\IntegrationSettingsControllerInterface;
use Tokenly\Wp\Interfaces\Models\IntegrationSettingsInterface;

/**
 * Handles the integration settings REST API endpoints
 */
class IntegrationSettingsController implements IntegrationSettingsControllerInterface {
	protected $settings;
	
	public function __construct(
		IntegrationSettingsInterface $settings
	) {
		$this->settings = $settings;
	}
	
	/**
	 * Responds with the settings
	 * @param WP_REST_Request $request Request data
	 * @return array
	 */
	public function show( $request ) {
		return $this->settings->to_array(); 
	}

	/**
	 * Updates the settings
	 * @param WP_REST_Request $request Request data
	 * @return array
	 */
	public function update( $request ) {
		$params = $request->get_params();
		$this->settings->update( $params );
		return array(
			'status' => 'Settings were updated successfully.',
		);
	}
}
