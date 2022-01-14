<?php

namespace Tokenly\Wp\Models;

use Tokenly\Wp\Models\Model;
use Tokenly\Wp\Interfaces\Models\SettingsInterface;

use Tokenly\Wp\Interfaces\Repositories\General\OptionRepositoryInterface;

class Settings extends Model implements SettingsInterface {
	/**
	 * @var string $option_prefix Prefix to add when saving or retrieving the options
	 */
	protected $option_prefix;
	
	public function __construct(
		OptionRepositoryInterface $domain_repository
	) {
		$this->domain_repository = $domain_repository;
		$data = $this->get_options();
		parent::__construct( $data );
	}

	/**
	 * Updates the settings
	 * @param array $settings New settings
	 * @return self
	 */
	public function save( array $settings = array() ) {
		$this->fill( $settings );
		$save_data = $this->to_array();
		$save_data = $this->prefix_options( $save_data );
		$this->domain_repository->update( $save_data );
		return $this;
	}

	/**
	 * Gets all settings
	 * @return array
	 */
	protected function get_options() {
		$fillable_prefixed = $this->get_fillable_prefixed();
		$options = $this->domain_repository->index( $fillable_prefixed );
		$options = $this->unprefix_options( $options );
		return $options;
	}

	/**
	 * Gets prefixed versions of keys for each fillable property
	 * @return string[]
	 */
	protected function get_fillable_prefixed() {
		if ( !isset( $this->fillable_prefixed ) || !is_array( $this->fillable_prefixed ) ) {
			$this->fillable_prefixed = array();
			foreach ( $this->fillable as $fillable ) {
				$this->fillable_prefixed[] = $this->prefix_key( $fillable );
			}
		}
		return $this->fillable_prefixed;
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
