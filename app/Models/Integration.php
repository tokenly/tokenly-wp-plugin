<?php

namespace Tokenly\Wp\Models;

use Tokenly\Wp\Models\Model;
use Tokenly\Wp\Interfaces\Models\IntegrationInterface;

use Tokenly\Wp\Interfaces\Models\Settings\IntegrationSettingsInterface;
use Tokenly\Wp\Interfaces\Repositories\General\OptionRepositoryInterface;
use Tokenly\TokenpassClient\TokenpassAPIInterface;

class Integration extends Model implements IntegrationInterface {
	public $settings;
	public $can_connect = false;
	protected $option_repository;
	protected $client;
	protected $fillable = array(
		'can_connect',
	);
	
	public function __construct(
		IntegrationSettingsInterface $settings,
		OptionRepositoryInterface $option_repository,
		TokenpassAPIInterface $client
	) {
		$this->settings = $settings;
		$this->option_repository = $option_repository;
		$this->client = $client;
		$integration_data = $this->option_repository->index( array(
				'integration_can_connect',
			)
		);
		$fill_data = array(
			'can_connect' => $integration_data['integration_can_connect'],
		);
		parent::__construct( $fill_data );
		if ( isset( $this->settings->settings_updated ) && $this->settings->settings_updated === true ) {
			$this->check_connection();
		}
	}

	/**
	 * Updates the connection state of the integration
	 * @return self
	 */
	public function check_connection() {
		$can_connect = false;
		$result = $this->client->getProvisionalSourceList();
		if ( $result === false ) {
			$can_connect = false;
		} else {
			$can_connect = true;
		}
		$this->option_repository->update( array(
			'integration_settings_updated' => false,
		) );
		$this->can_connect = $can_connect;
		$this->save();
		return $this;
	}
	
	/**
	 * Gets the current state of connection
	 * @return bool
	 */
	public function can_connect() {
		return $this->can_connect ?? false;
	}

	/**
	 * Saves the integration data
	 */
	public function save() {
		$save_data = $this->to_array();
		$save_data_formatted = array();
		foreach ( $save_data as $key => $save_data_item ) {
			$save_data_formatted[ "integration_{$key}" ] = $save_data_item;
		}
		$this->option_repository->update( $save_data_formatted );
		return $this;
	}
}
