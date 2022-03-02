<?php

use Tokenly\Wp\Interfaces\Controllers\Admin\Token\CategoryTermControllerInterface as TokenCategoryTermControllerInterface;
use Tokenly\Wp\Interfaces\Repositories\Token\CategoryTermRepositoryInterface as TokenCategoryTermRepositoryInterface;
use Tokenly\Wp\Interfaces\Controllers\Admin\TermControllerInterface;
use Tokenly\Wp\Interfaces\Repositories\TermRepositoryInterface;

return function(
		string $namespace,
		TokenCategoryTermControllerInterface $token_category_term_controller,
		TokenCategoryTermRepositoryInterface $token_category_term_repository,
		TermControllerInterface $term_controller,
		TermRepositoryInterface $term_repository
	) {
		return array(
			array(
				'id'              => 'token_meta',
				'taxonomy'        => array( "{$namespace}_token_category" ),
				'show_callback'   => array( $token_category_term_controller, 'show' ),
				'edit_callback'   => array( $token_category_term_controller, 'edit' ),
				'update_callback' => array( $token_category_term_repository, 'update' ),
			),
			array(
				'id'              => 'meta',
				'edit_callback'   => array( $term_controller, 'edit' ),
				'update_callback' => array( $term_repository, 'update' ),
			),
		);
};
