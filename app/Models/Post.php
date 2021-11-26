<?php

/**
 * WP_Post decorator
 */

namespace Tokenly\Wp\Models;

use Tokenly\Wp\Interfaces\Models\PostInterface;
use Tokenly\Wp\Interfaces\Services\Domain\PostServiceInterface;
use Tokenly\Wp\Interfaces\Collections\TcaRuleCollectionInterface;

class Post implements PostInterface {
	protected $_instance;
	protected $post_service;
	public $tca_rules;

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

	public function to_array() {
		$tca_rules = $this->get_tca_rules();
		$array = array(
			'tca_rules' => $tca_rules,
		);
		return $array;
	}
}
