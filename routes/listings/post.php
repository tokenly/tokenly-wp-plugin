<?php

use Tokenly\Wp\Interfaces\Presentation\Columns\TokenMetaFeaturedImageColumnInterface;

return function(
	TokenMetaFeaturedImageColumnInterface $token_meta_featured_image_column,
	string $namespace
) {
		$columns = function() use (
			$namespace, $token_meta_featured_image_column
		) {
			return array(
				array(
					'post_type' => array( "{$namespace}_token_meta" ),
					'id'        => "featured-image",
					'title'     => 'Featured Image',
					'callback'  => array(
						$token_meta_featured_image_column, 'column_callback'
					),
				),
			);
		};
		$actions = function() {
			return array(
				//
			);
		};
		return array(
			'columns' => $columns,
			'actions' => $actions,
		);
};
