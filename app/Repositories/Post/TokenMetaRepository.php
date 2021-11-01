<?php

namespace Tokenly\Wp\Repositories\Post;

use Tokenly\Wp\Repositories\General\MetaRepository;

class TokenMetaRepository {
	public $client;
	public $meta_repository;
	
	public function __construct(
		MetaRepository $meta_repository
	) {
		$this->meta_repository = $meta_repository;
	}

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
	
	public function show( $post_id ) {
		return $this->meta_repository->index( $post_id, array(
			'asset',
		) );
	}
	
	public function update( $post_id, $params ) {
		$this->meta_repository->update( $post_id, array(
			'asset' => $params['asset'] ?? null,
		) );
	}
}
