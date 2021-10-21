<?php

namespace Tokenly\Wp\Controllers\Api;

class WhitelistController {
	public function show( $request ) {
		$settings = get_option( 'tokenpass_whitelist', array() );
		return array(
			'use_whitelist' => $settings['use_whitelist'] ?? false,
			'whitelist'     => $settings['whitelist'] ?? array(),
		);
	}

	public function update( $request ) {
		$settings = $request['settings'] ?? null;
		if ( !$settings ) {
			return array(
				'status' => 'Error. Whitelist was not updated.',
			);
		}
		update_option( 'tokenpass_whitelist', array(
			'use_whitelist' => $settings['use_whitelist'] ?? false,
			'whitelist'     => $settings['whitelist'] ?? array(),
		) );
		return array(
			'status' => 'Whitelist was updated successfully.',
		);
	}
}
