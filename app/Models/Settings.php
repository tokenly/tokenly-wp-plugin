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

	protected function get_options() {
		$fillable_prefixed = $this->get_fillable_prefixed();
		$options = $this->domain_repository->index( $fillable_prefixed );
		$options = $this->unprefix_options( $options );
		return $options;
	}

	protected function get_fillable_prefixed() {
		if ( !isset( $this->fillable_prefixed ) ) {
			$this->fillable_prefixed = array();
			foreach ( $this->fillable as $fillable ) {
				$this->fillable_prefixed[] = $this->prefix_key( $fillable );
			}
		}
		return $this->fillable_prefixed;
	}

	protected function prefix_options( array $options = array() ) {
		$options_prefixed = array();
		foreach ( $options as $key => $option ) {
			$new_key = $this->prefix_key( $key );
			$options_prefixed[ $new_key ] = $option;
		}
		return $options_prefixed;
	}

	protected function unprefix_options( array $options = array() ) {
		$options_unprefixed = array();
		foreach ( $options as $key => $option ) {
			$new_key = $this->unprefix_key( $key );
			$options_unprefixed[ $new_key ] = $option;
		}
		return $options_unprefixed;
	}

	protected function is_key_prefixed( string $key ) {
		if ( strpos ( $key, "{$this->option_prefix}_" ) !== false ) {
			return true;
		}
		return false;
	}

	protected function prefix_key ( string $key ) {
		$new_key = "{$this->option_prefix}_{$key}";
		return $new_key;
	}

	protected function unprefix_key( string $key ) {
		$new_key = str_replace( "{$this->option_prefix}_", '', $key );
		return $new_key;
	}
}
