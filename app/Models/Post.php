<?php

/**
 * WP_Post decorator
 */

namespace Tokenly\Wp\Models;

use Tokenly\Wp\Models\Model;
use Tokenly\Wp\Interfaces\Models\PostInterface;
use Tokenly\Wp\Interfaces\Services\Domain\PostServiceInterface;
use Tokenly\Wp\Interfaces\Collections\TcaRuleCollectionInterface;

class Post extends Model implements PostInterface {
	public $tca_rules;
	protected $post;
	protected $post_service;
	protected $fillable = array(
		'post',
		'tca_rules',
	);

	public function __construct(
		PostServiceInterface $post_service,
		array $data = array()
	) {
		$this->post = $post;
		$this->post_service = $post_service;
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

	public function get_tca_rules() {
		if ( !isset( $this->tca_rules ) ) {
			$this->tca_rules = $this->post_service->get_tca_rules( $this->ID );
		}
		return $this->tca_rules;
	}

	public function set_tca_rules( TcaRuleCollectionInterface $rules ) {
		$this->$tca_rules = $rules;
		$this->post_service->set_tca_rules( $this->ID, $rules );
	}
}
