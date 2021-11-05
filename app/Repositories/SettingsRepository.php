<?php

namespace Tokenly\Wp\Repositories;

use Tokenly\Wp\Interfaces\Repositories\General\OptionRepositoryInterface;
use Tokenly\Wp\Interfaces\Repositories\SettingsRepositoryInterface;

/**
 * Manages plugin settings
 */
class SettingsRepository implements SettingsRepositoryInterface {
	public $option_repository;

	public function __construct(
		OptionRepositoryInterface $option_repository
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
	}

	public function is_configured() {
		$settings = $this->show();
		if ( !empty( $settings['client_id'] ?? null ) && !empty( $settings['client_secret'] ?? null ) ) {
			return true;
		} else {
			return false;
		}
	}
}
