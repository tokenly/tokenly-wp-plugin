<?php

/**
 * Plugin Name: Tokenpass OAuth 2.0
 * Plugin URI: https://www.tokenly.com/
 * Description: Tokenpass OAuth 2.0 integration plugin.
 * Version: 0.2
 * Author: Nick Arora
 * Author URI: https://tokenly.com/
**/

$path = preg_replace('/wp-content(?!.*wp-content).*/','',__DIR__);
include($path.'wp-load.php');

include( plugin_dir_path( __FILE__ ) . '/main-functions.php');
// include( plugin_dir_path( __FILE__ ) . '/account/authorize/auth.php');
// include( plugin_dir_path( __FILE__ ) . '/account/authorize/callback.php');

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

/* Create Tables for API & Report Generation */
function create_tokenpass_tables(){
    global $wpdb;
    // Create page object
    $my_post = array(
        'post_title'    => wp_strip_all_tags( 'Tokenpass Dashboard' ),
        'post_content'  => '',
        'post_status'   => 'publish',
        'post_author'   => 1,
        'post_type'     => 'page',
        );

	// Insert the post into the database
	$my_post_id = wp_insert_post( $my_post , true);

}

register_activation_hook(__FILE__, 'create_tokenpass_tables');

add_filter( 'page_template', 'wpa3396_page_template_tokenly' );
function wpa3396_page_template_tokenly( $page_template )
{
    if ( is_page( 'tokenpass-dashboard' ) ) {
        $page_template = dirname( __FILE__ ) . '/templates/tokenpass-dashboard.php';
    }
    return $page_template;
}
