<?php

namespace Tokenly\Wp\Repositories\Post;

use Tokenly\Wp\Interfaces\Repositories\Post\PostRepositoryInterface;
use Tokenly\Wp\Interfaces\Factories\Models\PostFactoryInterface;
use Tokenly\Wp\Interfaces\Models\PostInterface;
use Tokenly\Wp\Interfaces\Repositories\General\MetaRepositoryInterface;

/**
 * Manages post data
 */
class PostRepository implements PostRepositoryInterface {
	protected $post_factory;
	protected $meta_repository;
	
	public function __construct(
		PostFactoryInterface $post_factory,
		MetaRepositoryInterface $meta_repository
	) {
		$this->post_factory = $post_factory;
		$this->meta_repository = $meta_repository;
	}

	/**
	 * Queries the post matching the params
	 * @param array $params Search params
	 * @return PostInterface
	 */
	public function show( array $params = array() ) {
		$query_args = array(
			'post_type'   => 'any',
		);
		if ( isset( $params['id'] ) ) {
			$query_args['p'] = $params['id'];
		}
		$query = new \WP_Query( $query_args );
		$posts = $query->posts;
		if ( !isset( $posts[0] ) ) {
			return;
		}
		$post = $posts[0];
		if ( !$post ) {
			return;
		}
		$tca_rules = $this->meta_repository->show( $post->ID, 'tca_rules' ) ?? array();
		if ( empty( $tca_rules ) ) {
			$tca_rules = array();
		}
		$post = $this->post_factory->create( array(
			'post'      => $post,
			'tca_rules' => $tca_rules,
		) );
		return $post;
	}

	/**
	 * Updates the specific post
	 * @param PostInterface $post Target post
	 * @param array $params New data
	 * @return void
	 */
	public function update( PostInterface $post, array $params = array() ) {
		$update_params = array();
		if ( isset( $params['tca_rules'] ) ) {
			$update_params['tca_rules'] = $params['tca_rules'];
		}
		$this->meta_repository->update( $post->ID, $update_params );
	}
}
