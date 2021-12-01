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
	protected $fillable = array(
		'client_id',
		'client_secret',
	);

	public function __construct(
		IntegrationSettingsServiceInterface $integration_settings_service,
		array $data = array()
	) {
		$this->integration_settings_service = $integration_settings_service;
		parent::__construct( $data );
	}

	public function save() {
		$save_data = $this->to_array();
		$this->integration_settings_service->update( $save_data );
	}

	public function update( array $data ) {
		$this->fill( $data );
		$this->save();
	}
}
