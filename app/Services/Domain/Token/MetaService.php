<?php

namespace Tokenly\Wp\Services\Domain\Token;

use Tokenly\Wp\Services\Domain\DomainService;
use Tokenly\Wp\Interfaces\Services\Domain\Token\MetaServiceInterface;

use Tokenly\Wp\Interfaces\Repositories\Post\Token\MetaRepositoryInterface;
use Tokenly\Wp\Interfaces\Collections\Token\MetaCollectionInterface;
use Tokenly\Wp\Interfaces\Models\Token\MetaInterface;

/**
 * Manages the token meta
 */
class MetaService extends DomainService implements MetaServiceInterface {
	protected $meta_repository;

	public function __construct(
		MetaRepositoryInterface $meta_repository
	) {
		$this->meta_repository = $meta_repository;
	}

	/**
	 * Queries all the post meta matching the params
	 * @param array $params Search params
	 * @return MetaCollectionInterface Meta found
	 */
	public function index( array $params = array() ) {
		return $this->handle_method( __FUNCTION__, func_get_args() );
	}

	/**
	 * Retrieves a single token meta post
	 * @param array $params Post search params
	 * @return MetaInterface Meta found
	 */
	public function show( array $params = array() ) {
		return $this->handle_method( __FUNCTION__, func_get_args() );
	}

	/**
	 * Implementation of the "index" method. Will only
	 * run if no cached instance was found.
	 * @param array $params Search params
	 * @return MetaCollectionInterface Meta found
	 */
	protected function index_cacheable( array $params = array() ) {
		$posts = $this->meta_repository->index( $params ); 
		return $posts;
	}
	
	/**
	 * Implementation of the "show" method. Will only
	 * run if no cached instance was found.
	 * @param array $params Post search params
	 * @return MetaInterface Meta found
	 */
	protected function show_cacheable( array $params = array() ) {
		$meta = $this->meta_repository->show( $params ); 
		return $meta;
	}
}



