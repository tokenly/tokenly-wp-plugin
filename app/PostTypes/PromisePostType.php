<?php

namespace Tokenly\Wp\PostTypes;

class TokenMetaPostType {
	public function get_args() {
		$labels = array(
			'name'                  => _x( 'Token Meta', 'Post type general name', 'tokenly-wp-plugin' ),
			'singular_name'         => _x( 'Token Meta', 'Post type singular name', 'tokenly-wp-plugin' ),
			'menu_name'             => _x( 'Token Meta', 'Admin Menu text', 'tokenly-wp-plugin' ),
			'name_admin_bar'        => _x( 'Token Meta', 'Add New on Toolbar', 'tokenly-wp-plugin' ),
			'add_new'               => __( 'Add New', 'tokenly-wp-plugin' ),
			'add_new_item'          => __( 'Add New Token Meta', 'tokenly-wp-plugin' ),
			'new_item'              => __( 'New Token Meta', 'tokenly-wp-plugin' ),
			'edit_item'             => __( 'Edit Token Meta', 'tokenly-wp-plugin' ),
			'view_item'             => __( 'View Token Meta', 'tokenly-wp-plugin' ),
			'all_items'             => __( 'Token Meta', 'tokenly-wp-plugin' ),
			'search_items'          => __( 'Search Token Meta', 'tokenly-wp-plugin' ),
			'parent_item_colon'     => __( 'Parent Token Meta:', 'tokenly-wp-plugin' ),
			'not_found'             => __( 'No token meta found.', 'tokenly-wp-plugin' ),
			'not_found_in_trash'    => __( 'No token meta found in Trash.', 'tokenly-wp-plugin' ),
			'featured_image'        => _x( 'Token Meta Cover Image', 'Token Meta Cover Image', 'tokenly-wp-plugin' ),
			'set_featured_image'    => _x( 'Set cover image', 'Set cover image', 'tokenly-wp-plugin' ),
			'remove_featured_image' => _x( 'Remove cover image', 'Remove cover image', 'tokenly-wp-plugin' ),
			'use_featured_image'    => _x( 'Use as cover image', 'Use as cover image', 'tokenly-wp-plugin' ),
			'archives'              => _x( 'Token Meta archives', 'Token Meta archives', 'tokenly-wp-plugin' ),
			'insert_into_item'      => _x( 'Insert into token meta', 'Insert into token meta', 'tokenly-wp-plugin' ),
			'uploaded_to_this_item' => _x( 'Uploaded to this token meta', 'Uploaded to this token meta', 'tokenly-wp-plugin' ),
			'filter_items_list'     => _x( 'Filter token meta list', 'Filter token meta list', 'tokenly-wp-plugin' ),
			'items_list_navigation' => _x( 'Token Meta list navigation', 'Token Meta list navigation', 'tokenly-wp-plugin' ),
			'items_list'            => _x( 'Token Meta list', 'Token Meta list', 'tokenly-wp-plugin' ),
		);
	 
		$args = array(
			'labels'             => $labels,
			'public'             => false,
			'publicly_queryable' => true,
			'show_ui'            => true,
			'show_in_menu'       => 'tokenpass',
			'query_var'          => true,
			'capability_type'    => 'post',
			'has_archive'        => false,
			'hierarchical'       => false,
			'menu_position'      => 100,
			'supports'           => array( 'title', 'thumbnail', 'excerpt' ),
		);

		return $args;
	}
}
