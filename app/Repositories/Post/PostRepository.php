<?php

namespace Tokenly\Wp\Repositories\Post;

use Tokenly\Wp\Interfaces\Repositories\Post\PostRepositoryInterface;
use Tokenly\Wp\Interfaces\Factories\Models\PostFactoryInterface;
use Tokenly\Wp\Interfaces\Models\PostInterface;
use Tokenly\Wp\Interfaces\Repositories\General\MetaRepositoryInterface;
use Tokenly\Wp\Interfaces\Factories\Collections\TcaRuleCollectionFactoryInterface;

/**
 * Manages post data
 */
class PostRepository implements PostRepositoryInterface {
	protected $post_factory;
	protected $meta_repository;
	protected $meta = array(
		'tca_rules',
	);
	
	public function __construct(
		PostFactoryInterface $post_factory,
		MetaRepositoryInterface $meta_repository,
		TcaRuleCollectionFactoryInterface $tca_rule_collection_factory
	) {
		$this->post_factory = $post_factory;
		$this->meta_repository = $meta_repository;
		$this->tca_rule_collection_factory = $tca_rule_collection_factory;
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
		$post = $this->append_meta( $post );
		$post = $this->post_factory->create( $post );
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

	protected function load_meta( \WP_Post $post ) {
		$meta = $this->meta_repository->index( $post->ID, $this->meta );
		return $meta;
	}

	protected function append_meta( \WP_Post $post ) {
		$meta = $this->load_meta( $post );
		$post = array_merge( array(
			'post' => $post,
		), $meta );
		return $post;
	}

	protected function append_meta_collection( array $posts ) {
		foreach ( $posts as &$post ) {
			$post = $this->append_meta( $post );
		}
		return $posts;
	}
}
