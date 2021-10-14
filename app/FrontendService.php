<?php

/**
 * Handles main backend logic regarding frontend
 */

namespace Tokenly\Wp;

class FrontendService {
	public function __construct() {
		add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_scripts' ) );
		add_action( 'init', array( $this, 'tokenlyLoginCheck' ) );
	}

	public function register_scripts() {
		wp_register_script( 'tokenly-frontend', plugins_url( '/build/frontend.js', __FILE__ ), array(), null, true );
		wp_enqueue_script( 'tokenly-frontend' );
		wp_register_style( 'tokenly-frontend', plugins_url( '/build/frontend.css', __FILE__ ) );
		wp_enqueue_style( 'tokenly-frontend' );
	}
}
