<?php

namespace Tokenly\Wp\Services\Domain;

use Tokenly\Wp\Services\Domain\DomainService;
use Tokenly\Wp\Interfaces\Services\Domain\PostServiceInterface;
use Tokenly\Wp\Interfaces\Repositories\Post\PostRepositoryInterface;
use Tokenly\Wp\Interfaces\Repositories\General\MetaRepositoryInterface;

class PostService extends DomainService implements PostServiceInterface {
	protected $meta_repository;
	protected $post_repository;

	public function __construct(
		MetaRepositoryInterface $meta_repository,
		PostRepositoryInterface $post_repository
	) {
		$this->meta_repository = $meta_repository;
		$this->post_repository = $post_repository;
	}
	
	public function show( $params = array() ) {
		$post = $this->post_repository->show( $params );
		return $post;
	}
}



