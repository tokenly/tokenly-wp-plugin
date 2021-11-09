<?php

namespace Tokenly\Wp\Repositories;

use Tokenly\Wp\Interfaces\Repositories\General\OptionRepositoryInterface;
use Tokenly\Wp\Interfaces\Repositories\WhitelistRepositoryInterface;

/**
 * Manages token whitelist
 */
class WhitelistRepository implements WhitelistRepositoryInterface {
	protected $option_repository;

	public function __construct(
		OptionRepositoryInterface $option_repository
	) {
		$this->option_repository = $option_repository;
	}

	public function show() {
		return $this->option_repository->index( array(
			'use_whitelist',
			'whitelist',
		) );
	}
	
	public function update( $settings ) {
		$this->option_repository->update( array(
			'use_whitelist' => $settings['use_whitelist'] ?? false,
			'whitelist'     => $settings['whitelist'] ?? array(),
		) );
	}
}
