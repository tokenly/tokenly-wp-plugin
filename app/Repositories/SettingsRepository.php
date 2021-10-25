<?php

namespace Tokenly\Wp\Repositories;

class SettingsRepository {
	public function show() {
		return get_option( 'tokenpass_settings', array() );
	}
	
	public function update( $settings ) {
		update_option( 'tokenpass_settings', $settings );
	}
}
