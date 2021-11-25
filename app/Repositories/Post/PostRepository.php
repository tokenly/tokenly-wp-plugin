<?php

namespace Tokenly\Wp\Repositories\Post;

use Tokenly\Wp\Interfaces\Repositories\Post\PostRepositoryInterface;
use Tokenly\Wp\Interfaces\Factories\Models\PostFactoryInterface;
use Tokenly\Wp\Interfaces\Models\PostInterface;

/**
 * Manages post data
 */
class PostRepository implements PostRepositoryInterface {
	protected $post_factory;
	
	public function __construct(
		PostFactoryInterface $post_factory
	) {
		$this->post_factory = $post_factory;
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
		$post = $this->post_factory->create( $post );
		return $post;
	}
}
