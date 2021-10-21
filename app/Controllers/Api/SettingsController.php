<?php

namespace Tokenly\Wp\Controllers\Api;

class SettingsController {
	public $update_schema;
	
	public function show( $request ) {
		$settings = get_option( 'tokenpass_settings', array() );
		return $settings;
	}

	public function update( $request ) {
		$settings = $request['settings'] ?? null;
		if ( !$settings ) {
			return array(
				'status' => 'Error. Settings were not updated.',
			);
		}
		update_option( 'tokenpass_settings', $settings );
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
