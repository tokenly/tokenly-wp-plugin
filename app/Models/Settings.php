<?php

namespace Tokenly\Wp\Models;

use Tokenly\Wp\Interfaces\Models\SettingsInterface;
use Tokenly\Wp\Interfaces\Repositories\SettingsRepositoryInterface;

class Settings implements SettingsInterface {
	public $client_id;
	public $client_secret;
	protected $settings_repository;
	
	public function __construct(
		$settings_data = array(),
		SettingsRepositoryInterface $settings_repository
	) {
		$this->from_array( $settings_data );
		$this->settings_repository = $settings_repository;
	}

	public function save() {
		$save_data = $this->to_array();
		$this->settings_repository->update( $save_data );
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
		$client_id = $settings_data['client_id'] ?? null;
		if ( $client_id ) {
			$this->client_id = $client_id;
		}
		$client_secret = $settings_data['client_secret'] ?? null;
		if ( $client_secret ) {
			$this->client_secret = $client_secret;
		}
		return $this;
	}

	public function to_array() {
		$array = array();
		if ( $this->client_id ) {
			$array['client_id'] = $this->client_id;
		}
		if ( $this->client_secret ) {
			$array['client_secret'] = $this->client_secret;
		}
		return $array;
	}
}
