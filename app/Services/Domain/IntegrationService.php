<?php

namespace Tokenly\Wp\Services\Domain;

use Tokenly\Wp\Interfaces\Services\Domain\IntegrationServiceInterface;
use Tokenly\Wp\Interfaces\Models\IntegrationInterface;
use Tokenly\Wp\Interfaces\Repositories\General\OptionRepositoryInterface;
use Tokenly\Wp\Interfaces\Repositories\IntegrationRepositoryInterface;

/**
 * Manages integration
 */
class IntegrationService implements IntegrationServiceInterface {
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
		$integration = $this->integration_repository->show();
		return $integration;
	}
}
