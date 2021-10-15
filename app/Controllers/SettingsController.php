<?php

namespace Tokenly\Wp\Controllers;

class SettingsController {
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
}
