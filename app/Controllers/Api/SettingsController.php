<?php

namespace Tokenly\Wp\Controllers\Api;

use Tokenly\Wp\Interfaces\Controllers\Api\SettingsControllerInterface;
use Tokenly\Wp\Interfaces\Models\SettingsInterface;

/**
 * Handles the settings REST API endpoints
 */
class SettingsController implements SettingsControllerInterface {
	protected $update_schema;
	protected $settings;
	
	public function __construct(
		SettingsInterface $settings
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
	
	/**
	 * Sets the update route schema
	 * @return array
	 */
	public function update_get_schema() {
		if ( $this->update_schema ) {
			return $this->update_schema;
		}
		$this->update_schema = array(
			'$schema'              => 'http://json-schema.org/draft-04/schema#',
			'title'                => 'settings-update',
			'type'                 => 'object',
			'properties'           => array(
				'client_id'     => array(
					'type'         => 'string',
				),
				'client_secret' => array(
					'type'         => 'string',
				),
			),
		);
		return $this->update_schema;
	}
}
