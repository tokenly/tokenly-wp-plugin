<?php

namespace Tokenly\Wp\Models;

use Tokenly\Wp\Models\Model;
use Tokenly\Wp\Interfaces\Models\IntegrationSettingsInterface;
use Tokenly\Wp\Interfaces\Services\Domain\IntegrationSettingsServiceInterface;

class IntegrationSettings extends Model implements IntegrationSettingsInterface {
	public $client_id = '';
	public $client_secret = '';
	public $settings_updated = false;
	protected $integration_settings_service;
	
	public function __construct(
		IntegrationSettingsServiceInterface $integration_settings_service,
		array $data = array()
	) {
		$this->fill( $data );
		$this->integration_settings_service = $integration_settings_service;
	}

	public function save() {
		$save_data = $this->to_array();
		$this->integration_settings_service->update( $save_data );
	}

	public function update( array $data ) {
		$this->fill( $data );
		$this->save();
	}

	public function fill( array $data ) {
		if ( isset( $data['client_id'] ) ) {
			$this->client_id = $data['client_id'];
		}
		if ( isset( $data['client_secret'] ) ) {
			$this->client_secret = $data['client_secret'];
		}
		if ( isset( $data['settings_updated'] ) ) {
			$this->settings_updated = $data['settings_updated'];
		}
		return $this;
	}

	public function to_array() {
		$array = array();
		if ( isset( $this->client_id ) ) {
			$array['client_id'] = $this->client_id;
		}
		if ( isset( $this->client_secret ) ) {
			$array['client_secret'] = $this->client_secret;
		}
		if ( isset( $this->settings_updated ) ) {
			$array['settings_updated'] = $this->settings_updated;
		}
		return $array;
	}
}
