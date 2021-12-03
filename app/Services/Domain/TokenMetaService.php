<?php

namespace Tokenly\Wp\Services\Domain;

use Tokenly\Wp\Services\Domain\DomainService;
use Tokenly\Wp\Interfaces\Services\Domain\TokenMetaServiceInterface;
use Tokenly\Wp\Interfaces\Repositories\Post\TokenMetaRepositoryInterface;

/**
 * Manages the token meta
 */
class TokenMetaService extends DomainService implements TokenMetaServiceInterface {
	protected $token_meta_repository;

	public function __construct(
		TokenMetaRepositoryInterface $token_meta_repository
	) {
		$this->token_meta_repository = $token_meta_repository;
	}

	/**
	 * Queries all the post meta matching the params
	 * @param array $params Search params
	 * @return TokenMetaCollectionInterface
	 */
	public function index( array $params = array() ) {
		$posts = $this->token_meta_repository->index( $params ); 
		$posts = $this->index_after( $posts, $params );
		return $posts;
	}
	
	/**
	 * Retrieves a single token meta post
	 * @param array $params Post search params
	 * @return TokenMetaInterface
	 */
	public function show( array $params = array() ) {
		$meta = $this->token_meta_repository->index( $params ); 
		$meta = $this->show_after( $meta, $params );
		return $meta;
	}
}



