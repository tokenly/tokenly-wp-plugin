<?php
/**
 * Plugin Name:     Tokenpass OAuth 2.0
 * Plugin URI:      https://www.tokenly.com/
 * Description:     Tokenpass OAuth 2.0 integration plugin.
 * Author:          Nick Arora
 * Author URI:      https://tokenly.com/
 * Text Domain:     tokenly-wp-plugin
 * Domain Path:     /languages
 * Version:         0.3
 *
 * @package         Tokenly_Wp_Plugin
 */

namespace Tokenly\Wp;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

require plugin_dir_path( __FILE__ ) . 'vendor/autoload.php';

use Tokenly\Wp\Services\AdminService;
use Tokenly\Wp\Services\FrontendService;
use Tokenly\Wp\Routes\AdminRouter;
use Tokenly\Wp\Routes\ApiRouter;
use Tokenly\Wp\ShortcodeManager;

class Main {
	public $admin_service;
	public $frontend_service;
	public $api_router;
	public $admin_router;
	public $shortcode_manager;

	public function __construct() {
		$this->api_router_api = new ApiRouter();
		$this->api_router_api->register();
		$this->shortcode_manager = new ShortcodeManager();
		$this->shortcode_manager->init();
		if ( is_admin() ) {
			$this->admin_router = new AdminRouter();
			$this->admin_router->register();
			$this->admin_service = new AdminService();
			$this->admin_service->init();
		} else {
			$this->frontend_service = new FrontendService();
			$this->frontend_service->init();
		}
		register_activation_hook( __FILE__, array( self::class, 'on_activation' ) );
		register_uninstall_hook( __FILE__, array( self::class, 'on_uninstall' ) );
	}

	public static function on_activation() {
		//
	}

	public static function on_uninstall() {
		//
	}

}

new Main();
