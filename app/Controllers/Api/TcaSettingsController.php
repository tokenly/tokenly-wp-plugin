<?php

namespace Tokenly\Wp\Controllers\Api;

use Tokenly\Wp\Interfaces\Controllers\Api\TcaSettingsControllerInterface;
use Tokenly\Wp\Interfaces\Models\TcaSettingsInterface;

/**
 * Handles the TCA settings REST API endpoints
 */
class TcaSettingsController implements TcaSettingsControllerInterface {
	protected $settings;
	
	public function __construct(
		TcaSettingsInterface $settings
	) {
		$this->settings = $settings;
	}
	
	/**
	 * Responds with the settings
	 * @param WP_REST_Request $request Request data
	 * @return array
	 */
	public function show( $request ) {
		$settings = $this->settings->to_array(); 
		return $settings;
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
