<?php

namespace Tokenly\Wp\Models;

use Tokenly\Wp\Models\Model;
use Tokenly\Wp\Interfaces\Models\TcaSettingsInterface;
use Tokenly\Wp\Interfaces\Services\Domain\TcaSettingsServiceInterface;
use Tokenly\Wp\Interfaces\Repositories\General\OptionRepositoryInterface;

class TcaSettings extends Model implements TcaSettingsInterface {
	public $post_types = array();
	public $filter_menu_items = true;
	public $filter_post_results = true;
	protected $option_repository;
	protected $settings_prefix;
	
	public function __construct(
		OptionRepositoryInterface $option_repository
	) {
		$this->option_repository = $option_repository;

		$data = array(
			'post_types'          => $settings['tca_post_types'] ?? null,
			'filter_menu_items'   => $settings['tca_filter_menu_items'] ?? null,
			'filter_post_results' => $settings['tca_filter_post_results'] ?? null,
		);
		parent::__construct( $data );
	}

	protected function get_settings() {
		$fillable_prefixed = $this->get_fillable_prefixed();
		$settings = $this->option_repository->index( $fillable_prefixed );
		$settings_unprefixed = array();
		foreach ( $settings as $key => $setting ) {
			if ( !strpos ( $key, "{$this->settings_prefix}_" ) ) {
				continue;
			}
			
		}
		return $settings;
	}

	protected function get_fillable_prefixed() {
		if ( !isset( $this->fillable_prefixed ) ) {
			$this->fillable_prefixed = array();
			foreach ( $this->fillable as $fillable ) {
				$this->fillable_prefixed[] = "{$this->settings_prefix}_$fillable}";
			}
		}
		return $this->fillable_prefixed;
	}

	protected function prefix_settings() {

	}

	/**
	 * Updates the TCA settings
	 * @param array $settings New settings
	 * @return void
	 */
	public function save( array $settings = array() ) {
		$this->fill( $settings );
		$save_data = $this->to_array();
		$save_data_formatted = array();
		foreach ( $save_data as $key => $save_data_item ) {
			$save_data_formatted[ "tca_{$key}" ] = $save_data_item;
		}
		$this->option_repository->update( $save_data_formatted );
	}
}
