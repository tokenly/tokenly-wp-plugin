<?php

namespace Tokenly\Wp\Repositories\Post;

use Tokenly\Wp\Interfaces\Repositories\General\MetaRepositoryInterface;
use Tokenly\Wp\Interfaces\Repositories\Post\TokenMetaRepositoryInterface;
use Tokenly\Wp\Interfaces\Factories\Collections\TokenMetaCollectionFactoryInterface;
use Tokenly\Wp\Interfaces\Collections\TokenMetaCollectionInterface;
use Tokenly\Wp\Interfaces\Models\TokenMetaInterface;

class TokenMetaRepository implements TokenMetaRepositoryInterface {
	protected $client;
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
	public function index( $params ) {
		$query_args = array(
			'post_type'   => 'token-meta',
			'meta_query'  => array(),
		);
		$assets = $params['assets'] ?? null;
		if ( $assets ) {
			$query_args['meta_query'][] = array(
				'key'     => 'tokenly_asset',
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
	 * Retrieves the token-meta post by post ID
	 * @param integer $post_id Post index
	 * @return TokenMetaInterface
	 */
	public function show( $post_id ) {
		$meta = $this->meta_repository->index( $post_id, array(
			'asset',
			// 'extra',
		) );
		// $extra = $meta['extra'] ?? null;
		return $meta[0] ?? null;
	}
	
	/**
	 * Updates the token-meta post by post ID
	 * @param array $params New post data
	 * @return void
	 */
	public function update( $post_id, $params ) {
		$this->meta_repository->update( $post_id, array(
			'asset' => $params['asset'] ?? null,
			// 'extra' => $params['extra'] ?? null,
		) );
	}
}
