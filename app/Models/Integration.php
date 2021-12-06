<?php

namespace Tokenly\Wp\Models;

use Tokenly\Wp\Models\Model;
use Tokenly\Wp\Interfaces\Models\IntegrationInterface;
use Tokenly\Wp\Interfaces\Models\Settings\IntegrationSettingsInterface;
use Tokenly\Wp\Interfaces\Repositories\General\OptionRepositoryInterface;
use Tokenly\Wp\Interfaces\Repositories\SourceRepositoryInterface;

class Integration extends Model implements IntegrationInterface {
	public $settings;
	public $can_connect = false;
	protected $option_repository;
	protected $source_repository;
	protected $fillable = array(
		'can_connect',
	);
	
	public function __construct(
		IntegrationSettingsInterface $settings,
		OptionRepositoryInterface $option_repository,
		SourceRepositoryInterface $source_repository
	) {
		$this->settings = $settings;
		$this->option_repository = $option_repository;
		$this->source_repository = $source_repository;
		$integration_data = $this->option_repository->index( array(
				'integration_can_connect',
			)
		);
		$fill_data = array(
			'can_connect' => $integration_data['integration_can_connect'],
		);
		parent::__construct( $fill_data );
		if ( isset( $this->settings->settings_updated ) && $this->settings->settings_updated == true ) {
			$this->check_connection();
		}
	}

	public function check_connection() {
		$can_connect = false;
		$result = $this->source_repository->index();
		if ( $result == false ) {
			$can_connect = false;
		} else {
			$can_connect = true;
		}
		$this->settings->update( array(
			'settings_updated' => false,
		) );
		$this->can_connect = $can_connect;
		$this->save();
	}
	
	/**
	 * Tests whether the integration can connect
	 * @return bool
	 */
	public function can_connect() {
		return $this->can_connect ?? false;
	}

	public function save() {
		$save_data = $this->to_array();
		$save_data_formatted = array();
		foreach ( $save_data as $key => $save_data_item ) {
			$save_data_formatted[ "integration_{$key}" ] = $save_data_item;
		}
		$this->option_repository->update( $save_data_formatted );
	}
}
