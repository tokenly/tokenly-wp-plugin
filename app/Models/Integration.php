<?php

namespace Tokenly\Wp\Models;

use Tokenly\Wp\Interfaces\Models\IntegrationInterface;
use Tokenly\Wp\Interfaces\Models\IntegrationSettingsInterface;
use Tokenly\Wp\Interfaces\Repositories\IntegrationRepositoryInterface;

class Integration implements IntegrationInterface {
	public $settings;
	public $can_connect;
	protected $integration_repository;
	
	public function __construct(
		IntegrationSettingsInterface $settings,
		IntegrationRepositoryInterface $integration_repository
	) {
		$this->settings = $settings;
		$this->integration_repository = $integration_repository;
	}
	
	/**
	 * Tests whether the integration can connect
	 * @return bool
	 */
	public function can_connect() {
		if ( !isset( $this->can_connect ) ) {
			$result = $this->integration_repository->show();
			if ( $result ) {
				$this->can_connect = true;
			} else {
				$this->can_connect = false;
			}
		}
		return $this->can_connect;
	}
}