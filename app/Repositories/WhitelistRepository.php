<?php

namespace Tokenly\Wp\Repositories;

class WhitelistRepository {
	public function show() {
		$settings = get_option( 'tokenpass_whitelist', array() );
		return array(
			'use_whitelist' => $settings['use_whitelist'] ?? false,
			'whitelist'     => $settings['whitelist'] ?? array(),
		);
	}
	
	public function update( $settings ) {
		update_option( 'tokenpass_whitelist', array(
			'use_whitelist' => $settings['use_whitelist'] ?? false,
			'whitelist'     => $settings['whitelist'] ?? array(),
		) );
	}
}
