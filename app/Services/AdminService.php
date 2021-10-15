<?php

namespace Tokenly\Wp\Services;

/**
 * Handles main admin logic
 */

class AdminService {
	public $settings_service;

	public function __construct() {
		//
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
