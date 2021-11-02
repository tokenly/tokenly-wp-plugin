<?php

namespace Tokenly\Wp\Providers;

use Tokenly\Wp\Services\AuthService;

class AppServiceProvider {
	public $frontend_service;
	public $admin_service;
	public $auth_service;

	public function __construct(
		AuthService $auth_service
	) {
		$this->auth_service = $auth_service;
	}

	public function register() {
		register_activation_hook( __FILE__, array( self::class, 'on_activation' ) );
		register_uninstall_hook( __FILE__, array( self::class, 'on_uninstall' ) );

		add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_admin_scripts' ) );
		add_action( 'login_enqueue_scripts', array( $this, 'enqueue_admin_scripts' ) );
		add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_frontend_scripts' ) );
		add_action( 'login_footer', array( $this->auth_service, 'embed_tokenpass_login' ) );
	}

	public function enqueue_frontend_scripts() {
		wp_register_script( 'tokenly-frontend', plugins_url( '../../build/Frontend.js', __FILE__ ), array( 'wp-api' ), null, true );
		wp_enqueue_script( 'tokenly-frontend' );
		wp_register_style( 'tokenly-frontend', plugins_url( '../../build/Frontend.css', __FILE__ ) );
		wp_enqueue_style( 'tokenly-frontend' );
	}

	public function enqueue_admin_scripts() {
		wp_register_script( 'tokenly-admin', plugins_url( '../../build/Admin.js', __FILE__ ), array( 'wp-api', 'wp-i18n', 'wp-components', 'wp-element' ), null, true );
		wp_enqueue_script( 'tokenly-admin' );
		wp_register_style( 'tokenly-admin', plugins_url( '../../build/Admin.css', __FILE__ ), array( 'wp-components' ) );
		wp_enqueue_style( 'tokenly-admin' );
	}
	
	public static function on_activation() {
		flush_rewrite_rules();
	}

	public static function on_uninstall() {
		flush_rewrite_rules();
	}
}
