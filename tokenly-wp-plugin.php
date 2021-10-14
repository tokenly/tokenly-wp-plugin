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

use Tokenly\Wp\AdminService;
use Tokenly\Wp\Helper;
use Tokenly\TokenpassClient\TokenpassAPI;

class Main {
	public $adminService;

	public function __construct() {
		if ( is_admin() ) {
			$this->adminService = new AdminService();
		}
		register_activation_hook( __FILE__, array( self::class, 'on_activation' ) );
		register_uninstall_hook( __FILE__, array( self::class, 'on_uninstall' ) );
		add_filter( 'page_template', array( $this, 'wpa3396_page_template_tokenly' ) );

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

	/* Create Tables for API & Report Generation */
	public static function on_activation() {
		global $wpdb;
		// Create page object
		$my_post = array(
			'post_title'   => wp_strip_all_tags( 'Tokenpass Dashboard' ),
			'post_content' => '',
			'post_status'  => 'publish',
			'post_author'  => 1,
			'post_type'    => 'page',
		);

		// Insert the post into the database
		$my_post_id = wp_insert_post( $my_post, true );

		add_role(
			'tk_member', // System name of the role.
			'Tokenly Member', // Display name of the role.
			array(
				'read'                   => true,
				'tk_manage_options_user' => true,
			)
		);
	}

	/* Delete tables on plugin delete */
	public static function on_uninstall() {
		global $wpdb;
		$table_name = $wpdb->prefix . 'tk_data';
		$sql        = "DROP TABLE IF EXISTS $table_name";
		$wpdb->query( $sql );
		delete_option( 'my_plugin_db_version' );
	}

	public function wpa3396_page_template_tokenly( $page_template ) {
		if ( is_page( 'tokenpass-dashboard' ) ) {
			$page_template = dirname( __FILE__ ) . '/templates/tokenpass-dashboard.php';
		}
		return $page_template;
	}


}

new Main();
