<?php

use Tokenly\Wp\Interfaces\Controllers\Admin\PostControllerInterface;
use Tokenly\Wp\Interfaces\Controllers\Admin\Token\MetaControllerInterface as TokenMetaControllerInterface;
use Tokenly\Wp\Interfaces\Repositories\PostRepositoryInterface;
use Tokenly\Wp\Interfaces\Repositories\Token\MetaRepositoryInterface as TokenMetaRepositoryInterface;

return function(
		PostControllerInterface $post_controller,
		TokenMetaControllerInterface $token_meta_controller,
		PostRepositoryInterface $post_repository,
		TokenMetaRepositoryInterface $token_meta_repository,
		string $namespace
	) {
		return array(
			array(
				'post_type'       => array( "{$namespace}_token_meta" ),
				'id'              => 'token_meta',
				'title'           => 'Token Meta Editor',
				'show_callback'   => array( $token_meta_controller, 'show' ),
				'edit_callback'   => array( $token_meta_controller, 'edit' ),
				'update_callback' => array( $token_meta_repository, 'update' ),
			),
			array(
				'id'              => 'meta',
				'title'           => 'Post Editor',
				'edit_callback'   => array( $post_controller, 'edit' ),
				'update_callback' => array( $post_repository, 'update' ),
			),
		);
};
