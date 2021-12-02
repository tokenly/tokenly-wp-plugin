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
	protected $fillable = array(
		'post_types',
		'filter_menu_items',
		'filter_post_results',
	);
	
	public function __construct(
		OptionRepositoryInterface $option_repository
	) {
		$this->option_repository = $option_repository;
		$settings = $this->option_repository->index( array(
			'tca_post_types',
			'tca_filter_menu_items',
			'tca_filter_post_results',
		) );
		$data = array(
			'post_types'          => $settings['tca_post_types'] ?? null,
			'filter_menu_items'   => $settings['tca_filter_menu_items'] ?? null,
			'filter_post_results' => $settings['tca_filter_post_results'] ?? null,
		);
		parent::__construct( $data );
	}

	public function is_enabled_for_post_type( string $post_type ) {
		return $this->post_types[ $post_type ] ?? false;
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
