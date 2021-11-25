<?php

namespace Tokenly\Wp\Services\Domain;

use Tokenly\Wp\Interfaces\Services\Domain\TcaSettingsServiceInterface;
use Tokenly\Wp\Interfaces\Repositories\General\OptionRepositoryInterface;

/**
 * Manages tca settings
 */
class TcaSettingsService implements TcaSettingsServiceInterface {
	protected $option_repository;

	public function __construct(
		OptionRepositoryInterface $option_repository
	) {
		$this->option_repository = $option_repository;
	}

	public function show() {
		$settings = $this->option_repository->index( array(
			'tca_post_types',
		) );
		return array(
			'post_types' => $settings['tca_post_types'] ?? null,
		);
	}
	
	public function update( array $settings = array() ) {
		$this->option_repository->update( array(
			'tca_post_types' => $settings['post_types'] ?? null,
		) );
	}
}
