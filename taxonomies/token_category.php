<?php

use Tokenly\Wp\Interfaces\Repositories\Token\CategoryTermRepositoryInterface;

return function(
	string $text_domain,
	CategoryTermRepositoryInterface $repository
) {
	$labels = array(
		'name'              => _x(
			'Token Category', 'taxonomy general name', $text_domain
		),
		'singular_name'     => _x(
			'Category', 'taxonomy singular name', $text_domain
		),
		'search_items'      => __( 'Search Categories', $text_domain ),
		'all_items'         => __( 'All Categories', $text_domain ),
		'parent_item'       => __( 'Parent Category', $text_domain ),
		'parent_item_colon' => __( 'Parent Category:', $text_domain ),
		'edit_item'         => __( 'Edit Category', $text_domain ),
		'update_item'       => __( 'Update Category', $text_domain ),
		'add_new_item'      => __( 'Add New Category', $text_domain ),
		'new_item_name'     => __( 'New Category Name', $text_domain ),
		'menu_name'         => __( 'Genre', $text_domain ),
	);
	$args = array(
		'hierarchical'      => true,
		'labels'            => $labels,
		'show_ui'           => true,
		'show_admin_column' => true,
		'query_var'         => true,
		'repository'        => $repository,
	);
	return $args;
};
