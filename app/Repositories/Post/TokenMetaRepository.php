<?php

namespace Tokenly\Wp\Repositories\Post;

use Tokenly\Wp\Interfaces\Repositories\General\MetaRepositoryInterface;
use Tokenly\Wp\Interfaces\Repositories\Post\TokenMetaRepositoryInterface;

class TokenMetaRepository implements TokenMetaRepositoryInterface {
	public $client;
	public $meta_repository;
	
	public function __construct(
		MetaRepositoryInterface $meta_repository
	) {
		$this->meta_repository = $meta_repository;
	}

	/**
	 * Queries all the post meta matching the params
	 * @param array $params Search params
	 * @return WP_Query
	 */
	public function index( $params ) {
		$query_args = array(
			'post_type'      => 'token-meta',
			'meta_query'     => array(),
		);
		$assets = $params['assets'] ?? null;
		if ( $assets ) {
			$query_args['meta_query'][] = array(
				'key'     => 'tokenly_asset',
				'value'   => $params['assets'] ?? null,
				'compare' => 'IN',
			);
		}
		return $query_meta = new \WP_Query( $query_args );
	}
	
	/**
	 * Retrieves the token-meta post by post ID
	 * @param integer $post_id Post index
	 * @return array
	 */
	public function show( $post_id ) {
		$meta = $this->meta_repository->index( $post_id, array(
			'asset',
			// 'extra',
		) );
		// $extra = $meta['extra'] ?? null;
		return $meta;
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
