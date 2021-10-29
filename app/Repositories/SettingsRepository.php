<?php

namespace Tokenly\Wp\Repositories;

use Tokenly\Wp\Repositories\General\OptionRepository;

class SettingsRepository {
	public $option_repository;

	public function __construct(
		OptionRepository $option_repository
	) {
		$this->option_repository = $option_repository;
	}

	public function show() {
		return $this->option_repository->index( array(
			'client_id',
			'client_secret',
		) );
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
