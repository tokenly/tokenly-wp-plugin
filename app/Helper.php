<?php

/**
 * Plugin helper functions
 */

namespace Tokenly\Wp;

define( 'PLUGIN_DIR', dirname( __FILE__ ) . '/' );

class Helper {
	public function __construct() {
		add_filter( 'wp_new_user_notification_email', array( $this, 'custom_wp_new_user_notification_email_tk' ), 10, 3 );
		add_shortcode( 'tokenpass_login', array( $this, 'tokenpass_shortcode' ) );
		add_action( 'wp_ajax_nopriv_fetch_template', array( $this, 'fetch_template_tk' ) );
		add_action( 'wp_ajax_fetch_template', array( $this, 'fetch_template_tk' ) );
		add_action( 'init', array( $this, 'tokenly_login_check' ) );
	}

	/* The below function will help to load template file from plugin directory of WordPress*/
	public function tk_get_template_part( $slug, $name = null ) {
		do_action( "tk_get_template_part_{$slug}", $slug, $name );
		$templates = array();
		if ( isset( $name ) ) {
			$templates[] = "{$slug}-{$name}.php";
		}
		$templates[] = "{$slug}.php";
		tk_get_template_path( $templates, true, false );
	}

	/* Extend locate_template from WP Core Define a location of your plugin file dir to a constant in this case = PLUGIN_DIR_PATH */
	public function tk_get_template_path( $template_names, $load = false, $require_once = true ) {
		$located = '';
		foreach ( ( array ) $template_names as $template_name ) {
			if ( ! $template_name ) {
				continue;
			}
			/* search file within the PLUGIN_DIR_PATH only */
			if ( file_exists( plugin_dir_path( __FILE__ ) . $template_name ) ) {
				$located = plugin_dir_path( __FILE__ ) . $template_name;
				break;
			}
		}
		if ( $load && '' != $located ) {
			load_template( $located, $require_once );
		}
		return $located;
	}



	/* Create shortcode for calculator */
	public function tokenpass_shortcode() {
		load_template_part_tk( 'templates', 'login-btn' );
	}


	/* load template call function */
	public function load_template_part_tk( $template_name, $part_name = null ) {
		// ob_start();
		$var = tk_get_template_part( '' . $template_name . '/' . $part_name . '', null );
		// ob_end_clean();
		return $var;
	}

	/* Fetching template */
	public function fetch_template_tk() {
		load_template_part_tk( $_REQUEST['templateName'], $_REQUEST['fileName'] );
		wp_die();
	}

	public function tk_documentation_html() {
		echo '<h2> Coming Soon !! </h2>';
	}

	public function tokenly_login_check() {
		if ( isset( $_GET['error'] ) ) {
			if ( $_GET['error'] == 'yes' ) {
				$message = $_GET['message'];
				echo "<script>window.location.href = '/tokenly';</script>";
			} else {
				if ( $_GET['logged_in'] == 'yes' ) {
					$user_email = $_GET['useremail'];
					$message    = $user_email . ' you are successfully logged in.';
					echo "<script>window.location.href = '/tokenly/wp-admin';</script>";
				}
				if ( $_GET['user_register'] == 'yes' ) {
					$user_email = $_GET['useremail'];
					$message    = $user_email . ' you are registered successfully. please check your email for credentials';
					echo "<script>window.location.href = '/';</script>";
				}
			}
		}
	}

	public function custom_wp_new_user_notification_email_tk( $wp_new_user_notification_email, $user, $blogname ) {
		$user_login = stripslashes( $user->user_login );
		$user_email = stripslashes( $user->user_email );
		$user_pass  = get_user_meta( $user->data->ID, 'usr_pass', true );

		$login_url = wp_login_url();
		$message   = __( 'Hi there,' ) . '<br>';
		$message  .= sprintf( __( "Welcome to %s! Here's how to log in:" ), get_option( 'blogname' ) ) . '<br>';
		$message  .= wp_login_url() . '<br>';
		$message  .= sprintf( __( 'Username: %s' ), $user_login ) . '<br>';
		$message  .= sprintf( __( 'Email: %s' ), $user_email ) . '<br>';
		$message  .= sprintf( __( 'Password: %s' ), $user_pass ) . '<br>';
		$message  .= sprintf( __( 'If you have any problems, please contact me at %s.' ), get_option( 'admin_email' ) ) . '<br>';
		$message  .= __( 'bye!' );

		$wp_new_user_notification_email['subject'] = sprintf( '[%s] Your credentials.', $blogname );
		$wp_new_user_notification_email['headers'] = array( 'Content-Type: text/html; charset=UTF-8' );
		$wp_new_user_notification_email['message'] = $message;

		return $wp_new_user_notification_email;
	}
}
