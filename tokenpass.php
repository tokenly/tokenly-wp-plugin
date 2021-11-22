<?php

/**
 * Plugin Name: Tokenpass OAuth 2.0
 * Plugin URI: https://www.tokenly.com/
 * Description: Tokenpass OAuth 2.0 integration plugin.
 * Version: 0.3
 * Author: Nick Arora
 * Author URI: https://tokenly.com/
**/

$path = preg_replace('/wp-content(?!.*wp-content).*/','',__DIR__);
include($path.'wp-load.php');

include( plugin_dir_path( __FILE__ ) . '/main-functions.php');

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

/* Create Tables for API & Report Generation */
function tk_activation_function(){
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

    add_role( 
        'tk_member', // System name of the role.
        'Tokenly Member', // Display name of the role.
        array( 
            'read' => true, 
            'tk_manage_options_user' => true,
            'read'          => true,
            'edit_posts'    => true,
            'delete_posts'  => true,
            'publish_posts' => true,
            'upload_files'  => true,
            'delete_pages'  => true,
            'edit_pages'    => true,
            'publish_pages' => true,
            'manage_categories' => true,
            'delete_others_posts' => true,
            'delete_published_posts' =>true,
            'delete_published_pages' =>true,
            'edit_published_pages' => true,
            'edit_published_posts' => true,
            'delete_private_posts' => true,
            'delete_private_pages' => true,
            'edit_private_posts' => true,
            'edit_private_pages' => true,
            'edit_theme_options' => true,            
        ) 
    );
}

register_activation_hook(__FILE__, 'tk_activation_function');


function tk_deactivate_function(){
     remove_role( 'tk_member' );
}
register_deactivation_hook( __FILE__, 'tk_deactivate_function' );


add_filter( 'page_template', 'wpa3396_page_template_tokenly' );
function wpa3396_page_template_tokenly( $page_template )
{
    if ( is_page( 'tokenpass-dashboard' ) ) {
        $page_template = dirname( __FILE__ ) . '/templates/tokenpass-dashboard.php';
    }
    return $page_template;
}
