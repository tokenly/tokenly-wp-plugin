<?php

namespace Tokenly\Wp\Services\Domain;

use Tokenly\Wp\Interfaces\Services\Domain\TokenMetaServiceInterface;
use Tokenly\Wp\Interfaces\Repositories\Post\TokenMetaRepositoryInterface;
use Tokenly\Wp\Interfaces\Repositories\General\MetaRepositoryInterface;

class TokenMetaService implements TokenMetaServiceInterface {
	protected $token_meta_repository;
	protected $meta_repository;

	public function __construct(
		TokenMetaRepositoryInterface $token_meta_repository,
		MetaRepositoryInterface $meta_repository
	) {
		$this->token_meta_repository = $token_meta_repository;
		$this->meta_repository = $meta_repository;
	}

	/**
	 * Queries all the post meta matching the params
	 * @param array $params Search params
	 * @return TokenMetaCollectionInterface
	 */
	public function index( array $params = array() ) {
		$posts = $this->token_meta_repository->index( $params ); 
		return $posts;
	}
	
	/**
	 * Retrieves a single token meta post
	 * @param array $params Post search params
	 * @return TokenMetaInterface
	 */
	public function show( $params = array() ) {
		$meta = $this->index( $params );
		return $meta[0] ?? null;
	}
	
	/**
	 * Updates the token-meta post by post ID
	 * @param array $params New post data
	 * @return void
	 */
	public function update( int $post_id, array $params = array() ) {
		$this->meta_repository->update( $post_id, array(
			'asset' => $params['asset'] ?? null,
			'extra' => $params['extra'] ?? null,
		) );
	}

	public function get_token_meta( int $id ) {
		$meta = $this->meta_repository->index( $id, array(
			'asset',
			'extra',
		) );
		return $meta;
	}
}



