<?php

namespace Tokenly\Wp\Controllers\Api;

use Tokenly\Wp\Repositories\SettingsRepository;

class SettingsController {
	public $update_schema;
	public $settings_repository;
	
	public function __construct(
		SettingsRepository $settings_repository
	) {
		$this->settings_repository = $settings_repository;
	}
	
	public function show( $request ) {
		return $settings_repository->show(); 
	}

	public function update( $request ) {
		$settings = $request['settings'] ?? null;
		if ( !$settings ) {
			return array(
				'status' => 'Error. Settings were not updated.',
			);
		}
		$this->settings_repository->update( $settings );
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
                'client_id' => array(
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
