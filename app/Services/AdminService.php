<?php

namespace Tokenly\Wp\Services;

/**
 * Handles main admin logic
 */

use Tokenly\Wp\Services\Admin\SettingsService;

class AdminService {
	public $settings_service;

	public function __construct() {
		$this->settings_service = new SettingsService();
		$this->settings_service->init();
		if ( get_option( 'client_id_0' ) === false ) {
			update_option( 'client_id_0', '' );
		}
		if ( get_option( 'client_secret_1' ) === false ) {
			update_option( 'client_secret_1', '' );
		}
	}

	public function init() {
		add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_scripts' ) );
	}

	public function enqueue_scripts() {
		wp_register_script( 'tokenly-admin', plugins_url( '/build/admin.js', __FILE__ ), array(), null, true );
		wp_enqueue_script( 'tokenly-admin' );
		wp_register_style( 'tokenly-admin', plugins_url( '/build/admin.css', __FILE__ ) );
		wp_enqueue_style( 'tokenly-admin' );
	}
}
