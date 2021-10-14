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
use Tokenly\Wp\Helper;
use Tokenly\Wp\Router;
use Tokenly\Wp\ShortcodeManager;
use Tokenly\TokenpassClient\TokenpassAPI;

class Main {
	public $admin_service;
	public $frontend_service;
	public $router;
	public $shortcode_manager;

	public function __construct() {
		$this->route_manager = new Router();
		$this->shortcode_manager = new ShortcodeManager();
		if ( is_admin() ) {
			$this->admin_service = new AdminService();
		} else {
			$this->frontend_service = new FrontendService();
		}
		register_activation_hook( __FILE__, array( self::class, 'on_activation' ) );
		register_uninstall_hook( __FILE__, array( self::class, 'on_uninstall' ) );

		$client_id = '1984026217';
		$client_secret = 'KuvCYMsiBhZ9oGBP46yFrGuYQesuQK60BvcGroFQ';
		$privileged_client_id = '1984026217';
		$privileged_client_secret = 'KuvCYMsiBhZ9oGBP46yFrGuYQesuQK60BvcGroFQ';
		$tokenpass_url = 'https://tokenpass.tokenly.com';
		$redirect_uri = 'https://tokenly.local/tokenly/wp-content/plugins/tokenpass/account/authorize/callback.php';
		$oauth_client_id = null;
		$oauth_client_secret = null;
		$api = new TokenpassAPI( $client_id, $client_secret, $privileged_client_id, $privileged_client_secret, $tokenpass_url, $redirect_uri, $oauth_client_id, $oauth_client_secret );
		//error_log(print_r($api, true));
	}

	public static function on_activation() {
		add_role(
			'tk_member',
			'Tokenly Member',
			array(
				'read'                   => true,
				'tk_manage_options_user' => true,
			)
		);
	}

	public static function on_uninstall() {
		//
	}

}

new Main();
