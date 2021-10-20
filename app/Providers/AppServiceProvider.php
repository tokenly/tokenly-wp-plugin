<?php

namespace Tokenly\Wp\Providers;

use Tokenly\Wp\Services\AdminService;
use Tokenly\Wp\Services\FrontendService;
use Tokenly\Wp\Services\AuthService;

class AppServiceProvider {
	public $frontend_service;
	public $admin_service;
	public $auth_service;

	public function __construct(
		FrontendService $frontend_service,
		AdminService $admin_service,
		AuthService $auth_service
	) {
		$this->frontend_service = $frontend_service;
		$this->admin_service = $admin_service;
		$this->auth_service = $auth_service;
	}

	public function register() {
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
