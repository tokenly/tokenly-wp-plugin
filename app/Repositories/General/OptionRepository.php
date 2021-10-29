<?php

namespace Tokenly\Wp\Repositories\General;

/**
 * Helps to prefix all options being retrieved and saved by the app.
 */

class OptionRepository {
	public $namespace = 'tokenly';

	public function namespace_key( $key ) {
		return $this->namespace . '_' . $key;
	}

	public function index( $keys ) {
		$options = array();
		foreach ( $keys as $key ) {
			$options[ $key ] = $this->show( $key );
		}
		return $options;
	}

	public function show( $key ) {
		$key_namespaced = $this->namespace_key( $key );
		$option = get_option( $key_namespaced );
		return $option;
	}

	public function update( $payload ) {
		foreach ( $payload as $key => $value ) {
			$key_namespaced = $this->namespace_key( $key );
			update_option( $key_namespaced, $value );
		}
	}
}
