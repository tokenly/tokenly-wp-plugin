<?php

namespace Tokenly\Wp\Repositories\General;

use Tokenly\Wp\Interfaces\Repositories\General\OptionRepositoryInterface;

/**
 * Helps to prefix all options being retrieved and saved by the plugin.
 */
class OptionRepository implements OptionRepositoryInterface {
	protected string $namespace;

	public function __construct( string $namespace ) {
		$this->namespace = $namespace;
	}

	/**
	 * Retrieves the specified keys from the options
	 * @param array $keys Keys to retrieve
	 * @return array
	 */
	public function index( array $keys ): array {
		$options = array();
		foreach ( $keys as $key ) {
			$options[ $key ] = $this->show( $key );
		}
		return $options;
	}

	/**
	 * Retrieves the specified key from the options
	 * @param string $key Key to retrieve
	 * @return mixed
	 */
	public function show( string $key ) {
		$key = "{$this->namespace}_{$key}";
		$option = get_option( $key, null );
		return $option;
	}

	/**
	 * Updates the specified keys in the options
	 * @param array $payload Key-value pairs (option and value)
	 * @return void
	 */
	public function update( array $payload ): void {
		foreach ( $payload as $key => $value ) {
			$key = "{$this->namespace}_{$key}";
			update_option( $key, $value );
		}
	}
}
