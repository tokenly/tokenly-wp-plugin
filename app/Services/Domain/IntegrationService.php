<?php

namespace Tokenly\Wp\Services\Domain;

use Tokenly\Wp\Interfaces\Services\Domain\IntegrationServiceInterface;
use Tokenly\Wp\Interfaces\Services\Domain\SourceServiceInterface;
use Tokenly\Wp\Interfaces\Models\IntegrationInterface;
use Tokenly\Wp\Interfaces\Repositories\General\OptionRepositoryInterface;

/**
 * Manages integration
 */
class IntegrationService implements IntegrationServiceInterface {
	protected $option_repository;
	protected $source_service;

	public function __construct(
		OptionRepositoryInterface $option_repository,
		SourceServiceInterface $source_service
	) {
		$this->option_repository = $option_repository;
		$this->source_service = $source_service;
	}

	public function show() {
		$integration_data = $this->option_repository->index(
			'integration_can_connect',
		);
		return $integration_data;
	}

	public function check_connection() {
		$result = $this->source_service->index();
		if ( $result == false ) {
			return false;
		} else {
			return true;
		}
	}

	public function update( array $new_data = array() ) {
		$this->option_repository->update( array(
			'integration_can_connect' => $new_data['integration_can_connect'] ?? false,
		) );
	}

	public function can_connect() {
		$can_connect = boolval( $this->option_repository->show( 'integration_can_connect' ) ?? false );
		return $can_connect;
	}
}
