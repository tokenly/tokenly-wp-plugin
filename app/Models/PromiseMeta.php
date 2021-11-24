<?php

/**
 * WP_Post decorator
 */

namespace Tokenly\Wp\Models;

use Tokenly\Wp\Interfaces\Models\PromiseMetaInterface;
use Tokenly\Wp\Interfaces\Services\Domain\UserServiceInterface;
use Tokenly\Wp\Interfaces\Services\Domain\PromiseMetaServiceInterface;

class PromiseMeta implements PromiseMetaInterface {
	protected $_instance;
	protected $user_service;
	protected $promise_meta_service;

	public function __construct(
		\WP_Post $post,
		UserServiceInterface $user_service,
		PromiseMetaServiceInterface $promise_meta_service
	) {
		$this->_instance = $post;
		$this->promise_meta_service = $promise_meta_service;
		$this->user_service = $user_service;
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
		$meta = $this->promise_meta_service->get_meta( $this->ID );
		$uuids = array();
		if ( isset( $meta['source_user_id'] ) ) {
			$uuids[] = $meta['source_user_id'];
		}
		if ( isset( $meta['destination_user_id'] ) ) {
			$uuids[] = $meta['destination_user_id'];
		}
		$users = $this->user_service->index( array(
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
		$this->promise_meta_service->update( $this->ID, $params );
	}
	
	public function destroy() {
		$this->promise_meta_service->destroy( $this->ID );
	}
}
