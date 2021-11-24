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

	public function __construct(
		OptionRepositoryInterface $option_repository,
	) {
		$this->option_repository = $option_repository;
	}

	public function show() {
		$result = $this->option_repository->index( array(
			'client_id',
			'client_secret',
		) );
		return $result;
	}
	
	public function update( $settings ) {
		$this->option_repository->update( array(
			'client_id' => $settings['client_id'] ?? null,
			'client_secret' => $settings['client_secret'] ?? null,
		) );
		$this->can_connect = $this->integration_service->show();
		$this->option_repository->update( array(
			'integration_can_connect' => $this->can_connect,
		) );
	}
}
