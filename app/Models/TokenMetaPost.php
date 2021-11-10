<?php

/**
 * WP_Post decorator
 */

namespace Tokenly\Wp\Models;

use Tokenly\Wp\Interfaces\Models\TokenMetaPostInterface;

class TokenMetaPost implements TokenMetaPostInterface {
	protected $_instance;

	public function __construct(
		$token_meta_post
	) {
		$this->_instance = $token_meta_post;
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
