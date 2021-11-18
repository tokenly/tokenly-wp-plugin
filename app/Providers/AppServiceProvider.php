<?php

namespace Tokenly\Wp\Providers;

use Tokenly\Wp\Providers\ServiceProvider;
use Tokenly\Wp\Interfaces\Providers\AppServiceProviderInterface;
use Tokenly\Wp\Interfaces\Services\AuthServiceInterface;

/**
 * Registers general plugin modules
 */
class AppServiceProvider extends ServiceProvider implements AppServiceProviderInterface {
	protected $frontend_service;
	protected $admin_service;
	protected $auth_service;

	public function __construct(
		AuthServiceInterface $auth_service
	) {
		$this->auth_service = $auth_service;
	}

	/**
	 * Registers the service provider
	 * @return void
	 */
	public function register() {
		register_activation_hook( __FILE__, array( self::class, 'on_activation' ) );
		register_uninstall_hook( __FILE__, array( self::class, 'on_uninstall' ) );

		add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_admin_scripts' ) );
		add_action( 'login_enqueue_scripts', array( $this, 'enqueue_admin_scripts' ) );
		add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_frontend_scripts' ) );
		add_action( 'login_footer', array( $this->auth_service, 'embed_tokenpass_login' ) );
	}

	/**
	 * Embeds scripts and styles on frontend routes
	 * @wp-hook wp_enqueue_scripts
	 * @return void
	 */
	public function enqueue_frontend_scripts() {
		wp_register_script( 'tokenly-frontend', plugins_url( '../../build/Frontend.js', __FILE__ ), array( 'wp-api' ), null, true );
		wp_enqueue_script( 'tokenly-frontend' );
		wp_register_style( 'tokenly-frontend', plugins_url( '../../build/Frontend.css', __FILE__ ) );
		wp_enqueue_style( 'tokenly-frontend' );
	}

	/**
	 * Embeds scripts and styles on admin routes
	 * @wp-hook login_enqueue_scripts
	 * @wp-hook admin_enqueue_scripts
	 * @return void
	 */
	public function enqueue_admin_scripts() {
		wp_register_script( 'tokenly-admin', plugins_url( '../../build/Admin.js', __FILE__ ), array( 'wp-api', 'wp-i18n', 'wp-components', 'wp-element' ), null, true );
		wp_enqueue_script( 'tokenly-admin' );
		wp_register_style( 'tokenly-admin', plugins_url( '../../build/Admin.css', __FILE__ ), array( 'wp-components' ) );
		wp_enqueue_style( 'tokenly-admin' );
	}
	
	/**
	 * Plugin activation callback
	 * @return void
	 */
	public static function on_activation() {
		flush_rewrite_rules();
	}

	/**
	 * Plugin deactivation callback
	 * @return void
	 */
	public static function on_uninstall() {
		flush_rewrite_rules();
	}
}
