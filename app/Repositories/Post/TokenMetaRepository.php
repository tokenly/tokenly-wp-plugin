<?php

namespace Tokenly\Wp\Repositories\Post;

use Tokenly\Wp\Repositories\Post\PostRepository;
use Tokenly\Wp\Interfaces\Repositories\Post\TokenMetaRepositoryInterface;
use Tokenly\Wp\Interfaces\Factories\Models\TokenMetaFactoryInterface;
use Tokenly\Wp\Interfaces\Factories\Collections\TokenMetaCollectionFactoryInterface;
use Tokenly\Wp\Interfaces\Collections\TokenMetaCollectionInterface;
use Tokenly\Wp\Interfaces\Models\TokenMetaInterface;
use Tokenly\Wp\Interfaces\Repositories\General\MetaRepositoryInterface;

/**
 * Manages token meta data
 */
class TokenMetaRepository extends PostRepository implements TokenMetaRepositoryInterface {
	protected $namespace;
	
	public function __construct(
		TokenMetaFactoryInterface $post_factory,
		TokenMetaCollectionFactoryInterface $post_collection_factory,
		MetaRepositoryInterface $meta_repository,
		string $namespace
	) {
		$this->namespace = $namespace;
		parent::__construct(
			$post_factory,
			$post_collection_factory,
			$meta_repository
		);
	}

	protected function get_query_args( array $params = array() ) {
		$args = parent::get_query_args( $params );
		if ( isset( $params['assets'] ) ) {
			$args['meta_query'][] = array(
				'key'     => "{$this->namespace}_asset",
				'value'   => $params['assets'] ?? null,
				'compare' => 'IN',
			);
		}
		return $args;
	}

	protected function get_meta_fields() {
		$meta = parent::get_meta_fields();
		$meta = array_merge( $meta, array(
			'asset',
			'extra',
		) );
		return $meta;
	}

	protected function get_post_type() {
		return "{$this->namespace}_token_meta";
	}
}
