<?php

namespace Tokenly\Wp\Services\Domain\Token;

use Tokenly\Wp\Services\Domain\DomainService;
use Tokenly\Wp\Interfaces\Services\Domain\Token\PromiseMetaServiceInterface;

use Tokenly\Wp\Interfaces\Repositories\Post\Token\PromiseMetaRepositoryInterface;
use Tokenly\Wp\Interfaces\Models\Token\PromiseMetaInterface;
use Tokenly\Wp\Interfaces\Collections\Token\PromiseMetaCollectionInterface;

/**
 * Manages the promise meta
 */
class PromiseMetaService extends DomainService implements PromiseMetaServiceInterface {
	protected $promise_meta_repository;

	public function __construct(
		PromiseMetaRepositoryInterface $promise_meta_repository
	) {
		$this->promise_meta_repository = $promise_meta_repository;
	}

	/**
	 * Gets a collection of promise meta posts
	 * @param array $params Search params
	 * @return PromiseMetaCollectionInterface Promise meta found
	 */
	public function index( array $params = array() ) {
		return $this->handle_method( __FUNCTION__, func_get_args() );
	}

	/**
	 * Gets a single promise meta post
	 * @param integer $params Post search params
	 * @return PromiseMetaInterface Promise meta found
	 */
	public function show( array $params = array() ) {
		return $this->handle_method( __FUNCTION__, func_get_args() );
	}

	/**
	 * Makes a new promise meta post
	 * @param array $params New promise meta post data
	 * @return PromiseMetaInterface New promise meta
	 */
	public function store( array $params = array() ) {
		$post = $this->promise_meta_repository->store( $params );
		return $post;
	}

	/**
	 * Implementation of the "index" method. Will only
	 * run if no cached instance was found.
	 * @param array $params Search params
	 * @return PromiseMetaCollectionInterface Promise meta found
	 */
	protected function index_cacheable( array $params = array() ) {
		$promises = $this->promise_meta_repository->index( $params );
		return $promises;
	}
	
	/**
	 * Implementation of the "show" method. Will only
	 * run if no cached instance was found.
	 * @param integer $params Post search params
	 * @return PromiseMetaInterface Promise meta found
	 */
	protected function show_cacheable( array $params = array() ) {
		$meta = $this->promise_meta_repository->show( $params );
		return $meta;
	}
}



