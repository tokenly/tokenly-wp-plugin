<?php

namespace Tokenly\Wp\Repositories\Token;

use Tokenly\Wp\Repositories\PostRepository;
use Tokenly\Wp\Interfaces\Repositories\Token\MetaRepositoryInterface;

use Tokenly\Wp\Interfaces\Factories\Models\Token\MetaFactoryInterface;
use Tokenly\Wp\Interfaces\Factories\Collections\Token\MetaCollectionFactoryInterface;
use Tokenly\Wp\Interfaces\Factories\Collections\Tca\RuleCollectionFactoryInterface;
use Tokenly\Wp\Interfaces\Collections\Token\MetaCollectionInterface;
use Tokenly\Wp\Interfaces\Models\Token\MetaInterface;
use Tokenly\Wp\Interfaces\Repositories\General\PostMetaRepositoryInterface;

/**
 * Manages meta data
 */
class MetaRepository extends PostRepository implements MetaRepositoryInterface {
	protected $namespace;
	
	public function __construct(
		MetaFactoryInterface $post_factory,
		MetaCollectionFactoryInterface $post_collection_factory,
		PostMetaRepositoryInterface $meta_repository,
		RuleCollectionFactoryInterface $tca_rule_collection_factory,
		string $namespace
	) {
		$this->namespace = $namespace;
		parent::__construct(
			$post_factory,
			$post_collection_factory,
			$meta_repository,
			$tca_rule_collection_factory
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
