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

    $db_table_name = $wpdb->prefix . 'tk_data';  // table name
    $charset_collate = $wpdb->get_charset_collate();

    //Check to see if the table exists already, if not, then create it
    /* 
    if ($wpdb->get_var("show tables like '$db_table_name'") != $db_table_name) {
        $sql = "CREATE TABLE $db_table_name (
                id int(20) NOT NULL auto_increment,
                name varchar(30) NOT NULL,
                balance BIGINT(9) NOT NULL,
                interest_rate float(10) NOT NULL,
                monthly_charges BIGINT(9) NULL,
                monthly_payment BIGINT(9) NOT NULL,
                term INT(9) NOT NULL,
                report_date DATETIME,
                UNIQUE KEY id (id)
        ) $charset_collate;";

        require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
        dbDelta($sql);
    }*/
}

register_activation_hook(__FILE__, 'create_tokenpass_tables');
