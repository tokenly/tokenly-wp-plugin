<?php

namespace Tokenly\Wp\Models;

use Tokenly\Wp\Interfaces\Models\IntegrationInterface;
use Tokenly\Wp\Interfaces\Models\IntegrationSettingsInterface;
use Tokenly\Wp\Interfaces\Repositories\IntegrationRepositoryInterface;
use Tokenly\Wp\Interfaces\Repositories\General\OptionRepositoryInterface;

class Integration implements IntegrationInterface {
	public $settings;
	public $can_connect;
	protected $integration_repository;
	protected $option_repository;
	
	public function __construct(
		IntegrationSettingsInterface $settings,
		IntegrationRepositoryInterface $integration_repository,
		OptionRepositoryInterface $option_repository
	) {
		$this->settings = $settings;
		$this->integration_repository = $integration_repository;
		$this->option_repository = $option_repository;
	}
	
	/**
	 * Tests whether the integration can connect
	 * @return bool
	 */
	public function can_connect() {
		if ( !isset( $this->can_connect ) ) {
			$this->can_connect = boolval( $this->option_repository->show( 'integration_can_connect' ) );
		}
		return $this->can_connect;
	}
}
