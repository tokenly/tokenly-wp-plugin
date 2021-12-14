<?php

namespace Tokenly\Wp\Repositories\Post;

use Tokenly\Wp\Interfaces\Repositories\Post\TokenMetaRepositoryInterface;
use Tokenly\Wp\Interfaces\Factories\Collections\TokenMetaCollectionFactoryInterface;
use Tokenly\Wp\Interfaces\Collections\TokenMetaCollectionInterface;
use Tokenly\Wp\Interfaces\Models\TokenMetaInterface;
use Tokenly\Wp\Interfaces\Repositories\General\MetaRepositoryInterface;

/**
 * Manages token meta data
 */
class TokenMetaRepository implements TokenMetaRepositoryInterface {
	protected $token_meta_collection_factory;
	protected $meta_repository;
	protected $namespace;
	
	public function __construct(
		TokenMetaCollectionFactoryInterface $token_meta_collection_factory,
		MetaRepositoryInterface $meta_repository,
		string $namespace
	) {
		$this->token_meta_collection_factory = $token_meta_collection_factory;
		$this->meta_repository = $meta_repository;
		$this->namespace = $namespace;
	}

	/**
	 * Queries all the post meta matching the params
	 * @param array $params Search params
	 * @return TokenMetaCollectionInterface
	 */
	public function index( array $params = array() ) {
		$query_args = array(
			'post_type'   => "{$this->namespace}_token_meta",
			'meta_query'  => array(),
		);
		if ( isset( $params['id'] ) ) {
			$query_args['p'] = $params['id'];
		}
		if ( isset( $params['assets'] ) ) {
			$query_args['meta_query'][] = array(
				'key'     => "{$this->namespace}_asset",
				'value'   => $params['assets'] ?? null,
				'compare' => 'IN',
			);
		}
		$query_meta = new \WP_Query( $query_args );
		$posts = $query_meta->posts;
		foreach ( $posts as &$post ) {
			$post = array(
				'post' => $post,
			);
		}
		$collection = $this->token_meta_collection_factory->create( $posts );
		$collection->load( array( 'meta' ) );
		return $posts;
	}

	/**
	 * Retrieves a single token meta post
	 * @param integer $params Post search params
	 * @return TokenMetaInterface
	 */
	public function show( array $params = array() ) {
		$posts = $this->index( $params );
		if ( isset( $posts[0] ) ) {
			return $posts[0];
		}
	}

	/**
	 * Updates the specific token meta post
	 * @param TokenMetaInterface $post Target post
	 * @param array $params Update parameters
	 * @return void
	 */
	public function update( TokenMetaInterface $post, array $params = array() ) {
		$update_params = array();
		if ( isset( $params['asset'] ) ) {
			$update_params['asset'] = $params['asset'];
		}
		if ( isset( $params['extra'] ) ) {
			$update_params['extra'] = $params['extra'];
		}
		$this->meta_repository->update( $post->ID, $update_params );
	}
}
