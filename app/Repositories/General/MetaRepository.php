<?php

namespace Tokenly\Wp\Repositories\General;

/**
 * Helps to prefix all post meta being retrieved and saved by the app.
 */

class MetaRepository {
	public $namespace = 'tokenly';

	public function namespace_key( $key ) {
		return $this->namespace . '_' . $key;
	}

	public function index( $post_id, $keys ) {
		$options = array();
		foreach ( $keys as $key ) {
			$options[ $key ] = $this->show( $post_id, $key );
		}
		return $options;
	}

	public function show( $post_id, $key ) {
		$key_namespaced = $this->namespace_key( $key );
		$option = get_post_meta( $post_id, $key_namespaced );
		return $option;
	}

	public function update( $post_id, $payload ) {
		foreach ( $payload as $key => $value ) {
			$key_namespaced = $this->namespace_key( $key );
			update_post_meta( $post_id, $key_namespaced, $value );
		}
	}
}
