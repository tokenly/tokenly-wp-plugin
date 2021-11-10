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

	/**
	 * Retrieves whitelist data from options
	 * @return void
	 */
	public function show() {
		$whitelist = $this->option_repository->index( array(
			'whitelist_enabled',
			'whitelist_items',
		) );
		return array(
			'enabled' => $whitelist['whitelist_enabled'] ?? false,
			'items'   => $whitelist['whitelist_items'] ?? null,
		);
	}
	
	/**
	 * Updates whitelist data in options
	 * @param array $options New whitelist data
	 * @return void
	 */
	public function update( $options ) {
		$this->option_repository->update( array(
			'whitelist_enabled' => $options['enabled'] ?? false,
			'whitelist_items'   => $options['items'] ?? array(),
		) );
	}
}
