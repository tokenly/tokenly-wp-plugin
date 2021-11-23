<?php

namespace Tokenly\Wp\Repositories;

use Tokenly\Wp\Interfaces\Models\IntegrationInterface;
use Tokenly\Wp\Interfaces\Repositories\General\OptionRepositoryInterface;
use Tokenly\Wp\Interfaces\Repositories\IntegrationSettingsRepositoryInterface;
use Tokenly\Wp\Interfaces\Repositories\IntegrationRepositoryInterface;

/**
 * Manages integration settings
 */
class IntegrationSettingsRepository implements IntegrationSettingsRepositoryInterface {
	protected $option_repository;
	protected $integration_repository;

	public function __construct(
		OptionRepositoryInterface $option_repository,
		IntegrationRepositoryInterface $integration_repository
	) {
		$this->option_repository = $option_repository;
		$this->integration_repository = $integration_repository;
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
		$this->can_connect = $this->integration_repository->show();
		$this->option_repository->update( array(
			'integration_can_connect' => $this->can_connect,
		) );
	}
}
