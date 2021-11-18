<?php

/**
 * WP_Post decorator
 */

namespace Tokenly\Wp\Models;

use Tokenly\Wp\Interfaces\Models\TokenMetaInterface;
use Tokenly\Wp\Interfaces\Repositories\General\MetaRepositoryInterface;

class TokenMeta implements TokenMetaInterface {
	protected $_instance;
	protected $meta_repository;

	public function __construct(
		\WP_Post $post,
		MetaRepositoryInterface $meta_repository
	) {
		$this->_instance = $post;
		$this->meta_repository = $meta_repository;
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
			'asset',
			'extra',
		) );
		return $meta;
	}
}
