<?php

namespace Tokenly\Wp\Services\Domain;

use Tokenly\Wp\Interfaces\Services\Domain\IntegrationSettingsServiceInterface;
use Tokenly\Wp\Interfaces\Services\Domain\IntegrationServiceInterface;
use Tokenly\Wp\Interfaces\Models\IntegrationInterface;
use Tokenly\Wp\Interfaces\Repositories\General\OptionRepositoryInterface;

/**
 * Manages integration settings
 */
class IntegrationSettingsService implements IntegrationSettingsServiceInterface {
	protected $option_repository;
	protected $integration_service;

	public function __construct(
		OptionRepositoryInterface $option_repository,
		IntegrationServiceInterface $integration_service
	) {
		$this->option_repository = $option_repository;
		$this->integration_service = $integration_service;
	}

	public function show() {
		$settings = $this->option_repository->index( array(
			'client_id',
			'client_secret',
			'settings_updated',
		) );
		return $settings;
	}
	
	public function update( array $settings = array() ) {
		$this->option_repository->update( array(
			'client_id' => $settings['client_id'] ?? null,
			'client_secret' => $settings['client_secret'] ?? null,
			'settings_updated' => true,
		) );
	}
}
