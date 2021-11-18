<?php

namespace Tokenly\Wp\Repositories\General;

use Tokenly\Wp\Traits\NamespaceableTrait;
use Tokenly\Wp\Interfaces\Repositories\General\OptionRepositoryInterface;

/**
 * Helps to prefix all options being retrieved and saved by the plugin.
 */
class OptionRepository implements OptionRepositoryInterface {
	use NamespaceableTrait;

	/**
	 * Retrieves the specified keys from the options
	 * @param array $keys Keys to retrieve
	 * @return array
	 */
	public function index( $keys ) {
		$options = array();
		foreach ( $keys as $key ) {
			$options[ $key ] = $this->show( $key );
		}
		return $options;
	}

	/**
	 * Retrieves the specified key from the options
	 * @param string $key Key to retrieve
	 * @return string
	 */
	public function show( $key ) {
		$key_namespaced = $this->namespace_key( $key );
		$option = get_option( $key_namespaced, null );
		return $option;
	}

	/**
	 * Updates the specified keys in the options
	 * @param array $payload Key-value pairs (option and value)
	 * @return void
	 */
	public function update( $payload ) {
		foreach ( $payload as $key => $value ) {
			$key_namespaced = $this->namespace_key( $key );
			update_option( $key_namespaced, $value );
		}
	}
}
