<?php

namespace Tokenly\Wp\Decorators;

use Encore\Product_Badges\Badge;

class UserDecorator {

	protected $_instance;

	public function __construct( \WP_User $user ) {
		$this->_instance = $user;
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
