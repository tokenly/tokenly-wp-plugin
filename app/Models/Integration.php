<?php

namespace Tokenly\Wp\Models;

use Tokenly\Wp\Interfaces\Models\IntegrationInterface;
use Tokenly\Wp\Interfaces\Models\IntegrationSettingsInterface;
use Tokenly\Wp\Interfaces\Services\Domain\IntegrationServiceInterface;

class Integration implements IntegrationInterface {
	public $settings;
	public $can_connect;
	protected $integration_service;
	
	public function __construct(
		IntegrationSettingsInterface $settings,
		IntegrationServiceInterface $integration_service
	) {
		$this->settings = $settings;
		$this->integration_service = $integration_service;
	}
	
	/**
	 * Tests whether the integration can connect
	 * @return bool
	 */
	public function can_connect() {
		if ( !isset( $this->can_connect ) ) {
			$this->can_connect = true;
			//$this->can_connect = boolval( $this->option_repository->show( 'integration_can_connect' ) );
		}
		return $this->can_connect;
	}
}
