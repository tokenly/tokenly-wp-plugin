<?php

/**
 * WP_Post decorator
 */

namespace Tokenly\Wp\Models;

use Tokenly\Wp\Interfaces\Models\PromiseMetaInterface;

class PromiseMeta implements PromiseMetaInterface {
	protected $_instance;

	public function __construct(
		\WP_Post $post
	) {
		$this->_instance = $post;
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
}
