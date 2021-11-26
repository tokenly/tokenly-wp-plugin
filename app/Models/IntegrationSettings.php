<?php

namespace Tokenly\Wp\Models;

use Tokenly\Wp\Interfaces\Models\IntegrationSettingsInterface;
use Tokenly\Wp\Interfaces\Services\Domain\IntegrationSettingsServiceInterface;

class IntegrationSettings implements IntegrationSettingsInterface {
	public $client_id = '';
	public $client_secret = '';
	public $settings_updated = false;
	protected $integration_settings_service;
	
	public function __construct(
		$settings_data = array(),
		IntegrationSettingsServiceInterface $integration_settings_service
	) {
		$this->from_array( $settings_data );
		$this->integration_settings_service = $integration_settings_service;
	}

	public function save() {
		$save_data = $this->to_array();
		$this->integration_settings_service->update( $save_data );
	}

	public function update( $settings_data ) {
		$this->from_array( $settings_data );
		$this->save();
	}

	public function from_array( $settings_data ) {
		if ( isset( $settings_data['client_id'] ) ) {
			$this->client_id = $settings_data['client_id'];
		}
		if ( isset( $settings_data['client_secret'] ) ) {
			$this->client_secret = $settings_data['client_secret'];
		}
		if ( isset( $settings_data['settings_updated'] ) ) {
			$this->settings_updated = $settings_data['settings_updated'];
		}
		return $this;
	}

	public function to_array() {
		return array(
			'client_id'        => $this->client_id,
			'client_secret'    => $this->client_secret,
			'settings_updated' => $this->settings_updated,
		);
	}
}
