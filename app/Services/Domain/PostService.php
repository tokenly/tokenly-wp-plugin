<?php

namespace Tokenly\Wp\Services\Domain;

use Tokenly\Wp\Services\Domain\DomainService;
use Tokenly\Wp\Interfaces\Services\Domain\PostServiceInterface;
use Tokenly\Wp\Interfaces\Repositories\Post\PostRepositoryInterface;

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
	 * Searches for post using the specified parameters
	 * @param array $params Post search params 
	 * @return array
	 */
	public function show( array $params = array() ) {
		$post = $this->post_repository->show( $params );
		return $post;
	}
}



