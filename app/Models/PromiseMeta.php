<?php

/**
 * WP_Post decorator
 */

namespace Tokenly\Wp\Models;

use Tokenly\Wp\Interfaces\Models\PromiseMetaInterface;
use Tokenly\Wp\Interfaces\Repositories\General\MetaRepositoryInterface;
use Tokenly\Wp\Interfaces\Repositories\Post\PromiseMetaRepositoryInterface;
use Tokenly\Wp\Interfaces\Repositories\UserRepositoryInterface;

class PromiseMeta implements PromiseMetaInterface {
	protected $_instance;
	protected $meta_repository;
	protected $promise_meta_repository;
	protected $user_repository;

	public function __construct(
		\WP_Post $post,
		MetaRepositoryInterface $meta_repository,
		PromiseMetaRepositoryInterface $promise_meta_repository,
		UserRepositoryInterface $user_repository
	) {
		$this->_instance = $post;
		$this->meta_repository = $meta_repository;
		$this->user_repository = $user_repository;
	}

	public function __call( $method, $args ) {
		return call_user_func_array( array( $this->_instance, $method ), $args );
	}

	public function __get( $key ) {
		return $this->_instance->$key;
	}

	public function __set( $key, $val ) {
		return $this->_instance->$key = $val;
	}
	
	public function to_array() {
		$meta = $this->meta_repository->index( $this->ID, array(
			'promise_id',
			'source_user_id',
			'destination_user_id',
		) );
		$uuids = array();
		if ( isset( $meta['source_user_id'] ) ) {
			$uuids[] = $meta['source_user_id'];
		}
		if ( isset( $meta['destination_user_id'] ) ) {
			$uuids[] = $meta['destination_user_id'];
		}
		$users = $this->user_repository->index( array(
			'uuids' => $uuids,
		) );
		$users->key_by_uuid();
		$source_user = null;
		if ( isset( $meta['source_user_id'] ) && isset( $users[ $meta['source_user_id'] ] ) ) {
			$source_user = $users[ $meta['source_user_id'] ];
			$source_user = $source_user->to_array();
		}
		$destination_user = null;
		if ( isset( $meta['destination_user_id'] ) && isset( $users[ $meta['destination_user_id'] ] ) ) {
			$destination_user = $users[ $meta['destination_user_id'] ];
			$destination_user = $destination_user->to_array();
		}
		$array = array(
			'promise_id'       => $meta['promise_id'] ?? null, 
			'source_user'      => $source_user,
			'destination_user' => $destination_user,
		);
		return $array;
	}
	
	public function update( $params = array() ) {
		$this->promise_meta_repository->update( $this->ID, $params );
	}
	
	public function destroy() {
		$this->promise_meta_repository->destroy( $this->ID );
	}
}
