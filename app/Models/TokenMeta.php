<?php

/**
 * WP_Post decorator
 */

namespace Tokenly\Wp\Models;

use Tokenly\Wp\Models\Model;
use Tokenly\Wp\Interfaces\Models\TokenMetaInterface;
use Tokenly\Wp\Interfaces\Repositories\Post\TokenMetaRepositoryInterface;

class TokenMeta extends Model implements TokenMetaInterface {
	public $asset;
	public $extra;
	protected $post;
	protected $domain_repository;
	protected $fillable = array(
		'post',
		'asset',
		'extra',
	);

	public function __construct(
		TokenMetaRepositoryInterface $domain_repository,
		array $data = array()
	) {
		$this->domain_repository = $domain_repository;
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
