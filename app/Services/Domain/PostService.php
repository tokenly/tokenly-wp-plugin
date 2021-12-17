<?php

namespace Tokenly\Wp\Services\Domain;

use Tokenly\Wp\Services\Domain\DomainService;
use Tokenly\Wp\Interfaces\Services\Domain\PostServiceInterface;
use Tokenly\Wp\Interfaces\Repositories\Post\PostRepositoryInterface;
use Tokenly\Wp\Interfaces\Models\PostInterface;
use Tokenly\Wp\Interfaces\Collections\PostCollectionInterface;

/**
 * Manages the posts
 */
class PostService extends DomainService implements PostServiceInterface {
	protected $post_repository;

	public function __construct(
		PostRepositoryInterface $post_repository
	) {
		$this->post_repository = $post_repository;
	}
	
	/**
	 * Queries all the posts matching the params
	 * @param array $params Search params
	 * @return PostCollectionInterface
	 */
	protected function _index( array $params = array() ) {
		$posts = $this->post_repository->index( $params );
		return $posts;
	}

	/**
	 * Searches for post using the specified parameters
	 * @param array $params Post search params 
	 * @return array
	 */
	protected function _show( array $params = array() ) {
		$post = $this->post_repository->show( $params );
		return $post;
	}
	
	/**
	 * Decorates a single post
	 * @param \WP_Post $post Post to decorate
	 * @return PostInterface
	 */
	public function complete( \WP_Post $post ) {
		$post = $this->post_repository->complete( $post );
		return $post;
	}
	
	/**
	 * Decorates a collection of posts
	 * @param \WP_Post[] $posts Posts to decorate
	 * @return PostCollectionsInterface
	 */
	public function complete_collection( array $posts ) {
		$posts = $this->post_repository->complete_collection( $posts );
		return $posts;
	}
}



