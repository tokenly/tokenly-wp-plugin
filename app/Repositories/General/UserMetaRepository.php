<?php

/**
 * Helps to prefix all user meta being retrieved and saved by the plugin.
 */

namespace Tokenly\Wp\Repositories\General;

use Tokenly\Wp\Traits\NamespaceableTrait;

class UserMetaRepository {
	use NamespaceableTrait;

	public function index( $user_id, $keys ) {
		$options = array();
		foreach ( $keys as $key ) {
			$options[ $key ] = $this->show( $user_id, $key );
		}
		return $options;
	}

	public function show( $user_id, $key ) {
		$key_namespaced = $this->namespace_key( $key );
		$option = get_user_meta( $user_id, $key_namespaced, true );
		return $option;
	}

	public function update( $user_id, $payload ) {
		foreach ( $payload as $key => $value ) {
			$key_namespaced = $this->namespace_key( $key );
			update_user_meta( $user_id, $key_namespaced, $value );
		}
	}
}
