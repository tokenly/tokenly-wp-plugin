<?php

namespace Tokenly\Wp\Services\Domain;

use Tokenly\Wp\Services\Domain\DomainService;
use Tokenly\Wp\Interfaces\Services\Domain\PromiseMetaServiceInterface;
use Tokenly\Wp\Interfaces\Repositories\Post\PromiseMetaRepositoryInterface;
use Tokenly\Wp\Interfaces\Repositories\General\MetaRepositoryInterface;

/**
 * Manages the promise meta
 */
class PromiseMetaService extends DomainService implements PromiseMetaServiceInterface {
	protected $promise_meta_cache = array();
	protected $promise_meta_repository;
	protected $meta_repository;

	public function __construct(
		PromiseMetaRepositoryInterface $promise_meta_repository,
		MetaRepositoryInterface $meta_repository
	) {
		$this->promise_meta_repository = $promise_meta_repository;
		$this->meta_repository = $meta_repository;
	}

	/**
	 * Queries all the post meta matching the params
	 * @param array $params Search params
	 * @return PromiseMetaCollectionInterface
	 */
	public function index( array $params = array() ) {
		$promises = $this->promise_meta_repository->index( $params );
		$promises = $this->index_after( $promises, $params );
		return $promises;
	}
	
	/**
	 * Retrieves a single promise meta post
	 * @param integer $params Post search params
	 * @return PromiseMetaInterface
	 */
	public function show( array $params = array() ) {
		$meta = $this->promise_meta_repository->show( $params );
		$meta = $this->show_after( $meta, $params );
		return $meta;
	}
	
	/**
	 * Creates a new promise meta post
	 * @param array $params New promise meta post data
	 * @return PromiseMetaInterface
	 */
	public function store( array $params ) {
		$post = $this->promise_meta_repository->store( $params );
		return $post;
	}
}



