<?php

namespace Tokenly\Wp\Controllers\Api;

use Tokenly\Wp\Interfaces\Controllers\Api\SettingsControllerInterface;
use Tokenly\Wp\Interfaces\Repositories\SettingsRepositoryInterface;

/**
 * Handles the settings REST API endpoints
 */
class SettingsController implements SettingsControllerInterface {
	public $update_schema;
	public $settings_repository;
	
	public function __construct(
		SettingsRepositoryInterface $settings_repository
	) {
		$this->settings_repository = $settings_repository;
	}
	
	public function show( $request ) {
		return $this->settings_repository->show(); 
	}

	public function update( $request ) {
		$params = $request->get_params();
		$this->settings_repository->update( $params );
		return array(
			'status' => 'Settings were updated successfully.',
		);
	}
	
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
