<?php

namespace Tokenly\Wp\Repositories\General;

use Tokenly\Wp\Interfaces\Repositories\General\PostMetaRepositoryInterface;

/**
 * Helps to prefix all post meta being retrieved and saved by the plugin.
 */
class PostMetaRepository implements PostMetaRepositoryInterface {
	protected string $namespace;

	public function __construct( string $namespace ) {
		$this->namespace = $namespace;
	}

	/**
	 * Retrieves the specified keys from the post meta
	 * @param int $post_id Index of post to get the meta from
	 * @param array $keys Keys to retrieve
	 * @return array
	 */
	public function index( int $post_id, array $keys ): array {
		$options = array();
		foreach ( $keys as $key ) {
			$options[ $key ] = $this->show( $post_id, $key );
		}
		return $options;
	}

	/**
	 * Retrieves the specified key from the post meta
	 * @param int $post_id Index of post to get the meta from
	 * @param string $key Key of the meta item to retrieve
	 * @return mixed
	 */
	public function show( int $post_id, string $key ) {
		$key = "{$this->namespace}_{$key}";
		$option = get_post_meta( $post_id, $key , true );
		if ( empty( $option ) ) {
			return null;
		}
		return $option;
	}

	/**
	 * Updates the specified keys in the post meta
	 * @param int $post_id Index of post to update the meta in
	 * @param array $payload Key-value pairs (meta key and value)
	 * @return void
	 */
	public function update( int $post_id, array $payload ): void {
		foreach ( $payload as $key => $value ) {
			$key = "{$this->namespace}_{$key}";
			update_post_meta( $post_id, $key, $value );
		}
	}
}
