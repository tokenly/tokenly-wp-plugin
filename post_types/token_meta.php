<?php

use Tokenly\Wp\Interfaces\Repositories\Token\MetaRepositoryInterface;

return function( 
		string $namespace,
		string $text_domain,
		MetaRepositoryInterface $repository
	) {
		$labels = array(
			'name'                  => _x( 'Token Meta', 'Post type general name', $text_domain ),
			'singular_name'         => _x( 'Token Meta', 'Post type singular name', $text_domain ),
			'menu_name'             => _x( 'Token Meta', 'Admin Menu text', $text_domain ),
			'name_admin_bar'        => _x( 'Token Meta', 'Add New on Toolbar', $text_domain ),
			'add_new'               => __( 'Add New', $text_domain ),
			'add_new_item'          => __( 'Add New Token Meta', $text_domain ),
			'new_item'              => __( 'New Token Meta', $text_domain ),
			'edit_item'             => __( 'Edit Token Meta', $text_domain ),
			'view_item'             => __( 'View Token Meta', $text_domain ),
			'all_items'             => __( 'Token Meta', $text_domain ),
			'search_items'          => __( 'Search Token Meta', $text_domain ),
			'parent_item_colon'     => __( 'Parent Token Meta:', $text_domain ),
			'not_found'             => __( 'No token meta found.', $text_domain ),
			'not_found_in_trash'    => __( 'No token meta found in Trash.', $text_domain ),
			'featured_image'        => _x( 'Token Meta Cover Image', 'Token Meta Cover Image', $text_domain ),
			'set_featured_image'    => _x( 'Set cover image', 'Set cover image', $text_domain ),
			'remove_featured_image' => _x( 'Remove cover image', 'Remove cover image', $text_domain ),
			'use_featured_image'    => _x( 'Use as cover image', 'Use as cover image', $text_domain ),
			'archives'              => _x( 'Token Meta archives', 'Token Meta archives', $text_domain ),
			'insert_into_item'      => _x( 'Insert into token meta', 'Insert into token meta', $text_domain ),
			'uploaded_to_this_item' => _x( 'Uploaded to this token meta', 'Uploaded to this token meta', $text_domain ),
			'filter_items_list'     => _x( 'Filter token meta list', 'Filter token meta list', $text_domain ),
			'items_list_navigation' => _x( 'Token Meta list navigation', 'Token Meta list navigation', $text_domain ),
			'items_list'            => _x( 'Token Meta list', 'Token Meta list', $text_domain ),
		);
		$args = array(
			'labels'             => $labels,
			'show_ui'            => true,
			'show_in_menu'       => false,
			'query_var'          => true,
			'public'             => true,
			'capability_type'    => 'post',
			'supports'           => array( 'title', 'thumbnail', 'excerpt' ),
			'taxonomies'         => array( "{$namespace}_token_category" ),
			'repository'         => $repository,
			'rewrite' => array(
				'slug'       => "{$namespace}/token/meta",
				'with_front' => false
			),
		);
		return $args;
};
