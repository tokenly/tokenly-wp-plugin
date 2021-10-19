<?php

namespace Tokenly\Wp\Providers;

use Tokenly\Wp\Services\AdminService;
use Tokenly\Wp\Services\FrontendService;
use Tokenly\Wp\Services\AuthService;

class AppServiceProvider {
	public $frontend_service;
	public $admin_service;
	public $auth_service;

	public function boot() {
		$this->frontend_service = new FrontendService();
		$this->admin_service = new AdminService();
		$this->auth_service = new AuthService();

		register_activation_hook( __FILE__, array( self::class, 'on_activation' ) );
		register_uninstall_hook( __FILE__, array( self::class, 'on_uninstall' ) );

		add_action( 'admin_enqueue_scripts', array( $this->admin_service, 'enqueue_scripts' ) );
		add_action( 'login_enqueue_scripts', array( $this->admin_service, 'enqueue_scripts' ) );
		add_action( 'wp_enqueue_scripts', array( $this->frontend_service, 'enqueue_scripts' ) );

		add_action( 'login_footer', array( $this->auth_service, 'embed_tokenpass_login' ) );
	}

	public static function on_activation() {
		flush_rewrite_rules();
	}

	public static function on_uninstall() {
		flush_rewrite_rules();
	}
}
