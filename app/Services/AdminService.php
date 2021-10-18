<?php

namespace Tokenly\Wp\Services;

/**
 * Handles main admin logic
 */

class AdminService {

	public function enqueue_scripts() {
		wp_register_script( 'tokenly-admin', plugins_url( '../../build/admin.js', __FILE__ ), array( 'wp-api', 'wp-i18n', 'wp-components', 'wp-element' ), null, true );
		wp_enqueue_script( 'tokenly-admin' );
		wp_register_style( 'tokenly-admin', plugins_url( '../../build/admin.css', __FILE__ ), array( 'wp-components' ) );
		wp_enqueue_style( 'tokenly-admin' );
	}
}
