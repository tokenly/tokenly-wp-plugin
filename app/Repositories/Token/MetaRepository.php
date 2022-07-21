<?php

namespace Tokenly\Wp\Repositories\Token;

use Tokenly\Wp\Repositories\PostRepository;
use Tokenly\Wp\Interfaces\Repositories\Token\MetaRepositoryInterface;

use Tokenly\Wp\Collections\Token\MetaCollection;
use Tokenly\Wp\Models\Token\Meta;
use Tokenly\Wp\Interfaces\Collections\Token\MetaCollectionInterface;
use Tokenly\Wp\Interfaces\Models\Token\MetaInterface;
use Tokenly\Wp\Interfaces\Repositories\General\PostMetaRepositoryInterface;
use Tokenly\Wp\Interfaces\Repositories\TermRepositoryInterface;
use Tokenly\Wp\Interfaces\Models\PostInterface;

/**
 * Manages meta data
 */
class MetaRepository extends PostRepository implements MetaRepositoryInterface {
	protected string $namespace;
	protected string $class = Meta::class;
	protected string $class_collection = MetaCollection::class;
	
	public function __construct(
		PostMetaRepositoryInterface $meta_repository,
		TermRepositoryInterface $term_repository,
		string $namespace
	) {
		$this->namespace = $namespace;
		parent::__construct( $meta_repository, $term_repository );
	}

	/**
	 * @inheritDoc
	 */
	protected function get_query_args( array $params = array() ): array {
		$args = parent::get_query_args( $params );
		if ( isset( $params['assets'] ) ) {
			$assets = $params['assets'];
			$args['meta_query'][] = array(
				'key'     => "{$this->namespace}_asset_name",
				'value'   => $params['assets'] ?? null,
				'compare' => 'IN',
			);
		}
		return $args;
	}

	/**
	 * @inheritDoc
	 */
	protected function get_meta_fields(): array {
		$meta = array_merge( parent::get_meta_fields(), array(
			'asset',
			'asset_name',
			'attributes',
			'media',
			'blockchain',
			'protocol',
		) );
		return $meta;
	}

	/**
	 * @inheritDoc
	 */
	protected function get_post_type(): string {
		return "{$this->namespace}_token_meta";
	}

	/**
	 * @inheritDoc
	 */
	public function update( PostInterface $post, array $params = array() ): PostInterface {
		$post = parent::update( $post, $params );
		if ( !$post->asset ) {
			return $post;
		}
		$params = array(
			'asset_name' => $post->asset->name,
		);
		$post = parent::update( $post, $params );
		return $post;
	}
}
