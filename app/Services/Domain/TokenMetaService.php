<?php

namespace Tokenly\Wp\Services\Domain;

use Tokenly\Wp\Services\Domain\DomainService;
use Tokenly\Wp\Interfaces\Services\Domain\TokenMetaServiceInterface;

use Tokenly\Wp\Interfaces\Repositories\Post\TokenMetaRepositoryInterface;
use Tokenly\Wp\Interfaces\Collections\TokenMetaCollectionInterface;
use Tokenly\Wp\Interfaces\Models\TokenMetaInterface;

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
		return $this->handle_method( __FUNCTION__, func_get_args() );
	}

	/**
	 * Retrieves a single token meta post
	 * @param array $params Post search params
	 * @return TokenMetaInterface
	 */
	public function show( array $params = array() ) {
		return $this->handle_method( __FUNCTION__, func_get_args() );
	}

	/**
	 * Implementation of the "index" method. Will only
	 * run if no cached instance was found.
	 * @param array $params Search params
	 * @return TokenMetaCollectionInterface
	 */
	protected function index_cacheable( array $params = array() ) {
		$posts = $this->token_meta_repository->index( $params ); 
		return $posts;
	}
	
	/**
	 * Implementation of the "show" method. Will only
	 * run if no cached instance was found.
	 * @param array $params Post search params
	 * @return TokenMetaInterface
	 */
	protected function show_cacheable( array $params = array() ) {
		$meta = $this->token_meta_repository->show( $params ); 
		return $meta;
	}
}



