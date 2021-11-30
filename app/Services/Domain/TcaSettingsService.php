<?php

namespace Tokenly\Wp\Services\Domain;

use Tokenly\Wp\Services\Domain\DomainService;
use Tokenly\Wp\Interfaces\Services\Domain\TcaSettingsServiceInterface;
use Tokenly\Wp\Interfaces\Repositories\General\OptionRepositoryInterface;

/**
 * Manages the TCA settings
 */
class TcaSettingsService extends DomainService implements TcaSettingsServiceInterface {
	protected $option_repository;

	public function __construct(
		OptionRepositoryInterface $option_repository
	) {
		$this->option_repository = $option_repository;
	}

	/**
	 * Retrieves the TCA settings
	 * @return array
	 */
	public function show() {
		$settings = $this->option_repository->index( array(
			'tca_post_types',
			'tca_filter_menu_items',
			'tca_filter_post_results',
		) );
		return array(
			'post_types'          => $settings['tca_post_types'] ?? null,
			'filter_menu_items'   => $settings['tca_filter_menu_items'] ?? null,
			'filter_post_results' => $settings['tca_filter_post_results'] ?? null,
		);
	}
	
	/**
	 * Updates the TCA settings
	 * @param array $settings New settings
	 * @return void
	 */
	public function update( array $settings = array() ) {
		$this->option_repository->update( array(
			'tca_post_types'          => $settings['post_types'] ?? null,
			'tca_filter_menu_items'   => $settings['filter_menu_items'] ?? null,
			'tca_filter_post_results' => $settings['filter_post_results'] ?? null,
		) );
	}
}
