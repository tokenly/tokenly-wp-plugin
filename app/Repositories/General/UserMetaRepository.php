<?php

namespace Tokenly\Wp\Repositories\General;

use Tokenly\Wp\Interfaces\Repositories\General\UserMetaRepositoryInterface;

/**
 * Helps to prefix all user meta being retrieved and saved by the plugin.
 */
class UserMetaRepository implements UserMetaRepositoryInterface {
	protected string $namespace;

	public function __construct( string $namespace ) {
		$this->namespace = $namespace;
	}

	/**
	 * Retrieves the specified keys from the user meta
	 * @param int $user_id WordPress user ID
	 * @param array $keys User meta keys
	 * @return array
	 */
	public function index( int $user_id, string ...$keys ): array {
		$options = array();
		foreach ( $keys as $key ) {
			$options[ $key ] = $this->show( $user_id, $key );
		}
		return $options;
	}

	/**
	 * Retrieves the specified key from the user meta
	 * @param int $user_id WordPress user ID
	 * @param string $key User meta key
	 * @return mixed
	 */
	public function show( int $user_id, string $key ): mixed {
		$key = "{$this->namespace}_{$key}";
		$option = get_user_meta( $user_id, $key, true );
		if ( empty( $option ) ) {
			return null;
		}
		return $option;
	}

	/**
	 * Updates the specified keys in the user meta
	 * @param int $user_id WordPress user ID
	 * @param array $payload Key-value pair (meta key and value)
	 * @return void
	 */
	public function update( int $user_id, array $payload ): void {
		foreach ( $payload as $key => $value ) {
			$key = "{$this->namespace}_{$key}";
			update_user_meta( $user_id, $key, $value );
		}
	}

	/**
	 * Deletes user meta
	 * @param int $user_id ID of user whos meta will be deleted
	 * @param array $keys Meta keys to delete
	 * @return void
	 */
	public function destroy( int $user_id, ...$keys ): void {
		foreach ( $keys as $key ) {
			$key = "{$this->namespace}_{$key}";
			delete_user_meta( $user_id, $key );
		}
	}
}
