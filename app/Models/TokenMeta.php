<?php

/**
 * WP_Post decorator
 */

namespace Tokenly\Wp\Models;

use Tokenly\Wp\Models\Model;
use Tokenly\Wp\Interfaces\Models\TokenMetaInterface;
use Tokenly\Wp\Interfaces\Services\Domain\TokenMetaServiceInterface;

class TokenMeta extends Model implements TokenMetaInterface {
	public $asset;
	public $extra;
	protected $post;
	protected $token_meta_service;
	protected $fillable = array(
		'post'
	);

	public function __construct(
		TokenMetaServiceInterface $token_meta_service,
		array $data = array()
	) {
		$this->token_meta_service = $token_meta_service;
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
	
	public function to_array() {
		$array = parent::to_array();
		$array['name'] = $this->post_title;
		$array['description'] = $this->post_excerpt;
		return $array;
	}
}
