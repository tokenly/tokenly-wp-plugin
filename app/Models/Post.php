<?php

/**
 * WP_Post decorator
 */

namespace Tokenly\Wp\Models;

use Tokenly\Wp\Interfaces\Models\PostInterface;
use Tokenly\Wp\Interfaces\Services\Domain\PostServiceInterface;

class Post implements PostInterface {
	protected $_instance;
	protected $post_service;

	public function __construct(
		\WP_Post $post,
		PostServiceInterface $post_service
	) {
		$this->_instance = $post;
		$this->post_service = $post_service;
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
		$array = array(
			//
		);
		return $array;
	}
}
