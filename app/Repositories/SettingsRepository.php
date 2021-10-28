<?php

namespace Tokenly\Wp\Repositories;

class SettingsRepository {
	public function show() {
		return get_option( 'tokenpass_settings', array() );
	}
	
	public function update( $settings ) {
		update_option( 'tokenpass_settings', $settings );
	}

	public function is_configured() {
		$settings = $this->show();
		if ( !empty( $settings['client_id'] ?? null ) && !empty( $settings['client_secret'] ?? null ) ) {
			return true;
		} else {
			return false;
		}
	}
}
