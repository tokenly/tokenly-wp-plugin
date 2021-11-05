<?php

namespace Tokenly\Wp\Repositories\General;

use Tokenly\Wp\Traits\NamespaceableTrait;
use Tokenly\Wp\Interfaces\Repositories\General\UserMetaRepositoryInterface;

/**
 * Helps to prefix all user meta being retrieved and saved by the plugin.
 */
class UserMetaRepository implements UserMetaRepositoryInterface {
	use NamespaceableTrait;

	/**
	 * Retrieves the specified keys from the user meta
	 * @param integer $user_id WordPress user ID
	 * @param array $keys User meta keys
	 * @return array
	 */
	public function index( $user_id, $keys ) {
		$options = array();
		foreach ( $keys as $key ) {
			$options[ $key ] = $this->show( $user_id, $key );
		}
		return $options;
	}

	/**
	 * Retrieves the specified key from the user meta
	 * @param integer $user_id WordPress user ID
	 * @param string $key User meta key
	 * @return string
	 */
	public function show( $user_id, $key ) {
		$key_namespaced = $this->namespace_key( $key );
		$option = get_user_meta( $user_id, $key_namespaced, true );
		return $option;
	}

	/**
	 * Updates the specified keys in the user meta
	 * @param integer $user_id WordPress user ID
	 * @param array $payload Key-value pair (meta key and value)
	 * @return void
	 */
	public function update( $user_id, $payload ) {
		foreach ( $payload as $key => $value ) {
			$key_namespaced = $this->namespace_key( $key );
			update_user_meta( $user_id, $key_namespaced, $value );
		}
	}
}
