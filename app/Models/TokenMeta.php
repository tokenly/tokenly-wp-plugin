<?php

/**
 * WP_Post decorator
 */

namespace Tokenly\Wp\Models;

use Tokenly\Wp\Interfaces\Models\TokenMetaInterface;
use Tokenly\Wp\Interfaces\Services\Domain\TokenMetaServiceInterface;

class TokenMeta implements TokenMetaInterface {
	protected $_instance;
	protected $token_meta_service;

	public function __construct(
		\WP_Post $post,
		TokenMetaServiceInterface $token_meta_service
	) {
		$this->_instance = $post;
		$this->token_meta_service = $token_meta_service;
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

	public function get_token_meta() {
		$meta = $this->token_meta_service->get_token_meta( $this->ID );
		return $meta;
	}
	
	public function to_array() {
		$meta = $this->get_token_meta();
		$meta['name'] = $this->post_title;
		$meta['description'] = $this->post_excerpt;
		return $meta;
	}
}
