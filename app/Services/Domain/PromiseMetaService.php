<?php

namespace Tokenly\Wp\Services\Domain;

use Tokenly\Wp\Interfaces\Services\Domain\PromiseMetaServiceInterface;
use Tokenly\Wp\Interfaces\Repositories\Post\PromiseMetaRepositoryInterface;
use Tokenly\Wp\Interfaces\Repositories\General\MetaRepositoryInterface;

/**
 * Manages the promise meta
 */
class PromiseMetaService implements PromiseMetaServiceInterface {
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

	public function get_promise_meta( int $id ) {
		$meta = $this->meta_repository->index( $id, array(
			'promise_id',
			'source_user_id',
			'destination_user_id',
		) );
		return $meta;
	}

	/**
	 * Queries all the post meta matching the params
	 * @param array $params Search params
	 * @return PromiseMetaCollectionInterface
	 */
	public function index( array $params = array() ) {
		$promise_collection = $this->promise_meta_repository->index( $params );
		return $promise_collection;
	}
	
	/**
	 * Retrieves a single promise meta post
	 * @param integer $params Post search params
	 * @return PromiseMetaInterface
	 */
	public function show( $params = array() ) {
		$meta = $this->index( $params );
		return $meta[0] ?? null;
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
	
	/**
	 * Updates the token-meta post by post ID
	 * @param int $post_id Post index
	 * @param array $params New post data
	 * @return void
	 */
	public function update( int $post_id, array $params = array() ) {
		$update_params = array(
			'ID' => $post_id,
		);
		$update_params = array_merge( $update_params, $params );
		$post = $this->promise_meta_repository->update( $update_params );
		return $post;
	}
	
	/**
	 * Deletes the existing promise meta post
	 * @param int $post_id Post index
	 * @return void 
	 */
	public function destroy( int $post_id ) {
		$this->promise_meta_repository->destroy( $post_id );
	}
}



