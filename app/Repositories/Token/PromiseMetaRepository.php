<?php

namespace Tokenly\Wp\Repositories\Token;

use Tokenly\Wp\Repositories\PostRepository;
use Tokenly\Wp\Interfaces\Repositories\Token\PromiseMetaRepositoryInterface;

use Tokenly\Wp\Collections\Token\PromiseMetaCollection;
use Tokenly\Wp\Models\Token\PromiseMeta;
use Tokenly\Wp\Interfaces\Collections\Token\PromiseMetaCollectionInterface;
use Tokenly\Wp\Interfaces\Models\Token\PromiseMetaInterface;
use Tokenly\Wp\Interfaces\Models\Token\PromiseInterface;
use Tokenly\Wp\Interfaces\Repositories\General\PostMetaRepositoryInterface;
use Tokenly\Wp\Interfaces\Repositories\TermRepositoryInterface;

/**
 * Manages promise meta data
 */
class PromiseMetaRepository extends PostRepository implements PromiseMetaRepositoryInterface {
	protected string $namespace;
	protected string $class = PromiseMeta::class;
	protected string $class_collection = PromiseMetaCollection::class;
	
	public function __construct(
		PostMetaRepositoryInterface $meta_repository,
		TermRepositoryInterface $term_repository,
		string $namespace
	) {
		$this->namespace = $namespace;
		parent::__construct( $meta_repository, $term_repository );
	}

	protected function destroy_all() {
		$meta = $this->index();
		foreach ( (array) $meta as $meta_item ) {
			$this->destroy( $meta_item );
		}
	}

	/**
	 * Associates promise meta with the promise
	 * @param PromiseMetaInterface $promise_meta_data Promise meta to associate
	 * @return PromiseMetaInterface
	 */
	public function associate(
		PromiseMetaInterface $promise_meta,
		PromiseInterface $promise
	): PromiseMetaInterface {
		$this->update( $promise_meta, array(
			'promise_id' => $promise->promise_id,
		) );
		$promise->promise_meta = $promise_meta;
		return $promise_meta;
	}

	/**
	 * @inheritDoc
	 */
	protected function get_store_existing_post(
		array $params = array()
	): ?PromiseMetaInterface {
		$post = $this->show( array(
			'promise_ids' => array( $params['promise_id'] ),
		) );
		return $post;
	}

	/**
	 * @inheritDoc
	 */
	protected function get_store_args( array $params = array() ): array {
		$args = parent::get_store_args( $params );
		$args['post_status'] = 'private';
		return $args;
	}

	/**
	 * @inheritDoc
	 */
	protected function get_query_args( array $params = array() ): array {
		$args = parent::get_query_args( $params );
		$args['post_status'] = 'private';
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

	/**
	 * @inheritDoc
	 */
	protected function get_meta_fields(): array {
		$meta = parent::get_meta_fields();
		$meta = array_merge( $meta, array(
			'promise_id',
			'source_user_id',
			'destination_user_id',
		) );
		return $meta;
	}

	/**
	 * @inheritDoc
	 */
	protected function get_post_type(): string {
		return "{$this->namespace}_promise_meta";
	}
}
