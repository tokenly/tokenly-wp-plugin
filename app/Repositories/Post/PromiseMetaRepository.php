<?php

namespace Tokenly\Wp\Repositories\Post;

use Tokenly\Wp\Repositories\Post\PostRepository;
use Tokenly\Wp\Interfaces\Repositories\General\MetaRepositoryInterface;
use Tokenly\Wp\Interfaces\Repositories\Post\PromiseMetaRepositoryInterface;
use Tokenly\Wp\Interfaces\Factories\Models\PromiseMetaFactoryInterface;
use Tokenly\Wp\Interfaces\Factories\Collections\PromiseMetaCollectionFactoryInterface;
use Tokenly\Wp\Interfaces\Collections\PromiseMetaCollectionInterface;
use Tokenly\Wp\Interfaces\Models\PromiseMetaInterface;
use Tokenly\Wp\Interfaces\Models\PromiseInterface;

/**
 * Manages promise meta data
 */
class PromiseMetaRepository extends PostRepository implements PromiseMetaRepositoryInterface {
	protected $namespace;
	
	public function __construct(
		PromiseMetaFactoryInterface $post_factory,
		PromiseMetaCollectionFactoryInterface $post_collection_factory,
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

	protected function get_store_existing_post( $params ) {
		$post = $this->show( array(
			'promise_ids' => array( $params['promise_id'] ),
		) );
		return $post;
	}

	protected function get_query_args( array $params = array() ) {
		$args = parent::get_query_args( $params );
		if ( isset( $params['promise_ids'] ) ) {
			$promise_ids = $params['promise_ids'] ?? null;
			$args['meta_query'][] = array(
				'key'     => "{$this->namespace}_promise_id",
				'value'   => $promise_ids,
				'compare' => 'IN',
			);
		}
		return $args;
	}

	protected function get_meta_fields() {
		$meta = parent::get_meta_fields();
		$meta = array_merge( $meta, array(
			'promise_id',
			'source_user_id',
			'destination_user_id',
		) );
		return $meta;
	}

	protected function get_post_type() {
		return "{$this->namespace}_promise_meta";
	}
}
