<?php

namespace Tokenly\Wp\Repositories\Post;

use Tokenly\Wp\Interfaces\Repositories\General\MetaRepositoryInterface;
use Tokenly\Wp\Interfaces\Repositories\Post\TokenMetaRepositoryInterface;
use Tokenly\Wp\Interfaces\Factories\Collections\TokenMetaCollectionFactoryInterface;
use Tokenly\Wp\Interfaces\Collections\TokenMetaCollectionInterface;
use Tokenly\Wp\Interfaces\Models\TokenMetaInterface;

/**
 * Manages token meta data
 */
class TokenMetaRepository implements TokenMetaRepositoryInterface {
	protected $meta_repository;
	protected $token_meta_collection_factory;
	
	public function __construct(
		MetaRepositoryInterface $meta_repository,
		TokenMetaCollectionFactoryInterface $token_meta_collection_factory
	) {
		$this->meta_repository = $meta_repository;
		$this->token_meta_collection_factory = $token_meta_collection_factory;
	}

	/**
	 * Queries all the post meta matching the params
	 * @param array $params Search params
	 * @return TokenMetaCollectionInterface
	 */
	public function index( array $params = array() ) {
		$query_args = array(
			'post_type'   => 'tokenly_token_meta',
			'meta_query'  => array(),
		);
		if ( isset( $params['id'] ) ) {
			$query_args['p'] = $params['id'];
		}
		if ( isset( $params['assets'] ) ) {
			$query_args['meta_query'][] = array(
				'key'     => $this->meta_repository->namespace_key( 'asset' ),
				'value'   => $params['assets'] ?? null,
				'compare' => 'IN',
			);
		}
		$query_meta = new \WP_Query( $query_args );
		$posts = $query_meta->posts;
		$posts = $this->token_meta_collection_factory->create( $posts );
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
		error_log(print_r( $params, true ));
		$this->meta_repository->update( $post_id, array(
			'asset' => $params['asset'] ?? null,
			'extra' => $params['extra'] ?? null,
		) );
	}
}
