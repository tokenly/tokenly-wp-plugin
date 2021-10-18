<?php

namespace Tokenly\Wp\Providers;

use Tokenly\Wp\Services\AdminService;
use Tokenly\Wp\Services\FrontendService;

class AppServiceProvider {
	public $frontend_service;
	public $admin_service;

	public function boot() {
		$this->frontend_service = new FrontendService();
		$this->admin_service = new AdminService();

		register_activation_hook( __FILE__, array( self::class, 'on_activation' ) );
		register_uninstall_hook( __FILE__, array( self::class, 'on_uninstall' ) );

		add_action( 'admin_enqueue_scripts', array( $this->admin_service, 'enqueue_scripts' ) );
		add_action( 'wp_enqueue_scripts', array( $this->frontend_service, 'enqueue_scripts' ) );
	}

	public static function on_activation() {
		flush_rewrite_rules();
	}

	public static function on_uninstall() {
		flush_rewrite_rules();
	}
}
