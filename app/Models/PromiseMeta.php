<?php

/**
 * WP_Post decorator
 */

namespace Tokenly\Wp\Models;

use Tokenly\Wp\Interfaces\Models\PromiseMetaInterface;
use Tokenly\Wp\Interfaces\Services\Domain\UserServiceInterface;
use Tokenly\Wp\Interfaces\Repositories\Post\PromiseMetaRepository;

class PromiseMeta implements PromiseMetaInterface {
	public $source_user_id;
	public $source_user;
	public $destination_user_id;
	public $destination_user;
	protected $post;
	protected $user_service;
	protected $promise_meta_repository;
	protected $fillable = array(
		'post',
		'promise_id',
		'source_user_id',
		'destination_user_id',
	);

	public function __construct(
		UserServiceInterface $user_service,
		PromiseMetaRepositoryInterface $promise_meta_repository,
		array $data = array()
	) {
		$this->user_service = $user_service;
		$this->promise_meta_repository = $promise_meta_repository;
		parent::__construct( $data );
	}

	public function __call( $method, $args ) {
		return call_user_func_array( array( $this->post, $method ), $args );
	}

	public function __get( $key ) {
		return $this->post->$key;
	}

	public function __set( $key, $val ) {
		return $this->post->$key = $val;
	}

	protected function load_source_user( array $relation ) {
		$user = $this->user_service->show( array(
			'uuid' => $source_user_id,
			'with' => $relation,
		) );
		$this->source_user = $user;
		return $this;
	}

	protected function load_destination_user( array $relation ) {
		$user = $this->user_service->show( array(
			'uuid' => $destination_user_id,
			'with' => $relation,
		) );
		$this->destination_user = $user;
		return $this;
	}

	/**
	 * Updates the token-meta post by post ID
	 * @param int $post_id Post index
	 * @param array $params New post data
	 * @return self
	 */
	public function update( array $params = array() ) {
		$update_params = array(
			'ID' => $this->ID,
		);
		$update_params = array_merge( $update_params, $params );
		$post = $this->promise_meta_repository->update( $update_params );
		return $this;
	}
	
	/**
	 * Deletes the existing promise meta post
	 * @param int $post_id Post index
	 * @return void 
	 */
	public function destroy() {
		$this->promise_meta_repository->destroy( $this->ID );
	}
}
