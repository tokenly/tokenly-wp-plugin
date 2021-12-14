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
	protected $promise_meta_collection_factory;
	protected $meta_repository;
	protected $string;
	protected $meta = array(
		'asset',
		'extra',
	);
	
	public function __construct(
		PromiseMetaCollectionFactoryInterface $promise_meta_collection_factory,
		MetaRepositoryInterface $meta_repository,
		string $namespace
	) {
		$this->promise_meta_collection_factory = $promise_meta_collection_factory;
		$this->meta_repository = $meta_repository;
		$this->namespace = $namespace;
	}

	/**
	 * Queries all the post meta matching the params
	 * @param array $params Search params
	 * @return PromiseMetaCollectionInterface
	 */
	public function index( array $params = array() ) {
		$query_args = array(
			'post_type'   => "{$this->namespace}_promise_meta",
			'meta_query'  => array(),
		);
		if ( isset( $params['id'] ) ) {
			$query_args['p'] = $params['id'];
		}
		if ( isset( $params['promise_ids'] ) ) {
			$promise_ids = $params['promise_ids'] ?? null;
			$query_args['meta_query'][] = array(
				'key'     => "{$this->namespace}_promise_id",
				'value'   => $promise_ids,
				'compare' => 'IN',
			);
		}
		$query_meta = new \WP_Query( $query_args );
		$posts = $query_meta->posts;
		foreach ( $posts as &$post ) {
			$meta = $this->meta_repository->index( $post->ID, array(
				'asset',
				'extra',
			) );
			$post = array(
				'post' => $post
			);
			$post = array_merge( $post, $meta );
		}
		$collection = $this->promise_meta_collection_factory->create( $posts );
		return $collection;
	}
	
	/**
	 * Retrieves a single promise meta post
	 * @param integer $params Post search params
	 * @return PromiseMetaInterface
	 */
	public function show( $params = array() ) {
		$posts = $this->index( $params );
		if ( isset( $posts[0] ) ) {
			return $posts[0];
		}
	}
	
	/**
	 * Creates a new promise meta post
	 * @param array $params New promise meta post data
	 * @return PromiseMetaInterface
	 */
	public function store( array $params ) {
		if ( !isset( $params['promise_id'] ) ) {
			return;
		}
		$meta = array(
			'promise_id'          => $params['promise_id'],
			'source_user_id'      => $params['source_user_id'] ?? null,
			'destination_user_id' => $params['destination_user_id'] ?? null,
		);
		$meta_namespaced = array();
		foreach ( $meta as $key => $value ) {
			$key = "{$this->namespace}_{$key}";
			$meta_namespaced[ $key ] = $value;
		}
		$common_params = array(
			'meta_input' => $meta_namespaced,
		);
		$post = $this->show( array(
			'promise_ids' => array( $params['promise_id'] ),
		) );
		if ( $post ) {
			$update_params = array_merge( array(
				'ID' => $post->ID,
			), $common_params );
			$post = $this->update( $update_params );
		} else {
			$store_params = array_merge( array(
				'post_type'  => "{$this->namespace}_promise_meta",
			), $common_params );
			$post = wp_insert_post( $store_params );
			if ( is_int( $post ) ) {
				$post = $this->show( array(
					'id' => $post,
				) );
			}
		}
		return $post;
	}
	
	/**
	 * Updates the token-meta post by post ID
	 * @param PromiseMetaInterface $post Post to update
	 * @param array $params New post data
	 * @return PromiseMetaInterface
	 */
	public function update( PromiseMetaInterface $post, array $params = array() ) {
		$params['ID'] = $post->ID; 
		wp_update_post( $params );
		return $post;
	}
	
	/**
	 * Deletes the existing promise meta post
	 * @param PromiseMetaInterface $post Post to delete
	 * @return void 
	 */
	public function destroy( PromiseMetaInterface $post ) {
		wp_delete_post( $post->ID );
	}
}
