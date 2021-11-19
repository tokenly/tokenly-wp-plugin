<?php

namespace Tokenly\Wp\Models;

use Tokenly\Wp\Interfaces\Models\IntegrationSettingsInterface;
use Tokenly\Wp\Interfaces\Repositories\IntegrationSettingsRepositoryInterface;

class IntegrationSettings implements IntegrationSettingsInterface {
	public $client_id = '';
	public $client_secret = '';
	protected $integration_settings_repository;
	
	public function __construct(
		$settings_data = array(),
		IntegrationSettingsRepositoryInterface $integration_settings_repository
	) {
		$this->from_array( $settings_data );
		$this->integration_settings_repository = $integration_settings_repository;
	}

	public function save() {
		$save_data = $this->to_array();
		$this->integration_settings_repository->update( $save_data );
	}

	public function update( $settings_data ) {
		$this->from_array( $settings_data );
		$this->save();
	}

	public function is_configured() {
		if ( !empty( $this->client_id ?? null ) && !empty( $this->client_secret ?? null ) ) {
			return true;
		} else {
			return false;
		}
	}

	public function from_array( $settings_data ) {
		if ( isset( $settings_data['client_id'] ) ) {
			$this->client_id = $settings_data['client_id'];
		}
		if ( isset( $settings_data['client_secret'] ) ) {
			$this->client_secret = $settings_data['client_secret'];
		}
		return $this;
	}

	public function to_array() {
		return array(
			'client_id'     => $this->client_id,
			'client_secret' => $this->client_secret,
		);
	}
}