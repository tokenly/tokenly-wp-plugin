<?php

namespace Tokenly\Wp\Repositories\General;

use Tokenly\Wp\Interfaces\Repositories\General\TermMetaRepositoryInterface;

/**
 * Helps to prefix all term meta being retrieved and saved by the plugin.
 */
class TermMetaRepository implements TermMetaRepositoryInterface {
	protected $namespace;

	public function __construct(
		string $namespace
	) {
		$this->namespace = $namespace;
	}

	/**
	 * Retrieves the specified keys from the term meta
	 * @param integer $term_id Index of term to get the meta from
	 * @param array $keys Keys to retrieve
	 * @return array
	 */
	public function index( int $term_id, ...$keys ) {
		$options = array();
		foreach ( $keys as $key ) {
			$options[ $key ] = $this->show( $term_id, $key );
		}
		return $options;
	}

	/**
	 * Retrieves the specified key from the term meta
	 * @param integer $term_id Index of term to get the meta from
	 * @param string $key Key of the meta item to retrieve
	 * @return string
	 */
	public function show( int $term_id, $key ) {
		$key = "{$this->namespace}_{$key}";
		$option = get_term_meta( $term_id, $key , true );
		return $option;
	}

	/**
	 * Updates the specified keys in the term meta
	 * @param integer $term_id Index of term to update the meta for
	 * @param array $payload Key-value pairs (meta key and value)
	 * @return void
	 */
	public function update( int $term_id, $payload ) {
		foreach ( $payload as $key => $value ) {
			$key = "{$this->namespace}_{$key}";
			update_term_meta( $term_id, $key, $value );
		}
	}
}
