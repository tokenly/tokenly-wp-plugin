<?php

namespace Tokenly\Wp\Repositories;

use Tokenly\Wp\Repositories\Repository;
use Tokenly\Wp\Interfaces\Repositories\SettingsRepositoryInterface;

use Tokenly\Wp\Interfaces\Repositories\General\OptionRepositoryInterface;
use Tokenly\Wp\Interfaces\Models\SettingsInterface;

/**
 * Manages post data
 */
class SettingsRepository extends Repository implements SettingsRepositoryInterface {
	protected string $option_prefix = '';
	protected array $meta_keys = array();
	protected array $meta_keys_prefixed = array();
	protected string $class = SettingsInterface::class;
	protected OptionRepositoryInterface $option_repository;

	public function __construct(
		OptionRepositoryInterface $option_repository
	) {
		$this->option_repository = $option_repository;
		$this->meta_keys_prefixed = $this->get_meta_keys_prefixed();
	}

	public function show(): ?SettingsInterface {
		$meta = $this->option_repository->index( $this->meta_keys_prefixed );
		$meta = $this->unprefix_options( $meta );
		$settings = ( new $this->class() )->from_array( $meta );
		return $settings; 
	}

	public function update( array $params = array() ): void {
		$params = $this->prefix_options( $params );
		$this->option_repository->update( $params );
	}

	protected function get_meta_keys_prefixed(): array {
		$prefixed = array();
		foreach ( $this->meta_keys as $meta_key ) {
			$prefixed[] = "{$this->option_prefix}_{$meta_key}";
		}
		return $prefixed;
	}

	/**
	 * Prefixes all keys for the specified array of options
	 * @param array $options Array of options to prefix
	 * @return array
	 */
	protected function prefix_options( array $options = array() ) {
		$options_prefixed = array();
		foreach ( $options as $key => $option ) {
			$new_key = $this->prefix_key( $key );
			$options_prefixed[ $new_key ] = $option;
		}
		return $options_prefixed;
	}

	/**
	 * Unprefixes all keys for the specified array of options
	 * @param array $options Array of options to unprefix
	 * @return array
	 */
	protected function unprefix_options( array $options = array() ) {
		$options_unprefixed = array();
		foreach ( $options as $key => $option ) {
			$new_key = $this->unprefix_key( $key );
			$options_unprefixed[ $new_key ] = $option;
		}
		return $options_unprefixed;
	}

	/**
	 * Checks whether the specified key is prefixed
	 * @param string $key
	 * @return bool
	 */
	protected function is_key_prefixed( string $key ) {
		if ( strpos ( $key, "{$this->option_prefix}_" ) !== false ) {
			return true;
		}
		return false;
	}

	/**
	 * Prefixes the specified key
	 * @param string $key Key
	 * @return string
	 */
	protected function prefix_key ( string $key ) {
		$new_key = "{$this->option_prefix}_{$key}";
		return $new_key;
	}

	/**
	 * Removes prefix from the specified key
	 * @param string $key Prefixed key
	 * @return string
	 */
	protected function unprefix_key( string $key ) {
		$new_key = str_replace( "{$this->option_prefix}_", '', $key );
		return $new_key;
	}
}
