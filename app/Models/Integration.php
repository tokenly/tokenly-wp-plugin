<?php

namespace Tokenly\Wp\Models;

use Tokenly\Wp\Models\Model;
use Tokenly\Wp\Interfaces\Models\IntegrationInterface;
use Tokenly\Wp\Interfaces\Models\IntegrationSettingsInterface;
use Tokenly\Wp\Interfaces\Services\Domain\IntegrationServiceInterface;

class Integration extends Model implements IntegrationInterface {
	public $settings;
	public $can_connect = false;
	protected $integration_service;
	protected $fillable = array(
		'settings',
	);
	
	public function __construct(
		IntegrationSettingsInterface $settings,
		IntegrationServiceInterface $integration_service
	) {
		$this->settings = $settings;
		$this->integration_service = $integration_service;
		if ( isset( $this->settings->settings_updated ) && $this->settings->settings_updated == true ) {
			$this->check_connection();
		}
	}

	public function check_connection() {
		$can_connect = $this->integration_service->check_connection();
		$this->settings->update( array(
			'settings_updated' => false,
		) );
		$this->can_connect = $can_connect;
		$this->update();
	}
	
	/**
	 * Tests whether the integration can connect
	 * @return bool
	 */
	public function can_connect() {
		return $this->can_connect ?? false;
	}

	public function update() {
		$new_data = $this->to_array();
		$this->integration_service->update( $new_data );
	}
}
