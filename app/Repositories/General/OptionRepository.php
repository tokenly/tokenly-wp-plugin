<?php

namespace Tokenly\Wp\Repositories\General;

use Tokenly\Wp\Traits\NamespaceableTrait;

/**
 * Helps to prefix all options being retrieved and saved by the plugin.
 */
class OptionRepository {
	use NamespaceableTrait;

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
