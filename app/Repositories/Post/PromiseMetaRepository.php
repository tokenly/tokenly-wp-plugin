<?php

namespace Tokenly\Wp\Repositories\Post;

use Tokenly\Wp\Interfaces\Repositories\General\MetaRepositoryInterface;
use Tokenly\Wp\Interfaces\Repositories\Post\PromiseMetaRepositoryInterface;
use Tokenly\Wp\Interfaces\Factories\Collections\PromiseMetaCollectionFactoryInterface;
use Tokenly\Wp\Interfaces\Collections\PromiseMetaCollectionInterface;
use Tokenly\Wp\Interfaces\Models\PromiseMetaInterface;
use Tokenly\Wp\Interfaces\Models\PromiseInterface;

/**
 * Manages promise meta data
 */
class PromiseMetaRepository implements PromiseMetaRepositoryInterface {
	protected $client;
	protected $meta_repository;
	protected $promise_meta_collection_factory;
	
	public function __construct(
		MetaRepositoryInterface $meta_repository,
		PromiseMetaCollectionFactoryInterface $promise_meta_collection_factory
	) {
		$this->meta_repository = $meta_repository;
		$this->promise_meta_collection_factory = $promise_meta_collection_factory;
	}

	/**
	 * Queries all the post meta matching the params
	 * @param array $params Search params
	 * @return PromiseMetaCollectionInterface
	 */
	public function index( array $params = array() ) {
		$query_args = array(
			'post_type'   => 'tokenly_promise_meta',
			'meta_query'  => array(),
		);
		if ( isset( $params['id'] ) ) {
			$query_args['p'] = $params['id'];
		}
		if ( isset( $params['promise_ids'] ) ) {
			$query_args['meta_query'][] = array(
				'key'     => $this->meta_repository->namespace_key( 'promise_id' ),
				'value'   => $params['promise_ids'] ?? null,
				'compare' => 'IN',
			);
		}
		$query_meta = new \WP_Query( $query_args );
		$posts = $query_meta->posts;
		$collection = $this->promise_meta_collection_factory->create( $posts );
		return $collection;
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
	
	public function store( array $params ) {
		if ( !isset( $params['promise_id'] ) ) {
			return;
		}
		$common_params = array(
			'meta_input' => array(
				'promise_id'          => $params['promise_id'],
				'source_user_id'      => $params['source_user_id'] ?? null,
				'destination_user_id' => $params['destination_user_id'] ?? null,
			),
		);
		$post = $this->show( array(
			'promise_id' => $params['promise_id'],
		) );
		if ( $post ) {
			$update_params = array_merge( array(
				'ID' => $post->ID,
			), $common_params );
			$this->update( $update_params );
		}
		$store_params = array_merge( array(
			'post_type'  => 'tokenly_promise_meta',
		), $common_params );
		$post = wp_insert_post( $store_params );
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
		$post = wp_update_post( $update_params );
	}
}
