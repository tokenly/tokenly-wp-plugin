<?php

namespace Tokenly\Wp\Repositories\Post;

use Tokenly\Wp\Interfaces\Repositories\Post\TokenMetaRepositoryInterface;
use Tokenly\Wp\Interfaces\Factories\Collections\TokenMetaCollectionFactoryInterface;
use Tokenly\Wp\Interfaces\Collections\TokenMetaCollectionInterface;
use Tokenly\Wp\Interfaces\Models\TokenMetaInterface;

/**
 * Manages token meta data
 */
class TokenMetaRepository implements TokenMetaRepositoryInterface {
	protected $token_meta_collection_factory;
	
	public function __construct(
		TokenMetaCollectionFactoryInterface $token_meta_collection_factory
	) {
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
}
