<?php

namespace Tokenly\Wp\Presentation\Views\Admin;

use Tokenly\Wp\Presentation\Views\DynamicViewModel;
use Tokenly\Wp\Interfaces\Presentation\Views\Admin\TermEditViewModelInterface;

use Tokenly\Wp\Interfaces\Models\Settings\TcaSettingsInterface;
use Tokenly\Wp\Interfaces\Repositories\TermRepositoryInterface;
use Tokenly\Wp\Interfaces\Repositories\Settings\TcaSettingsRepositoryInterface;
use Tokenly\Wp\Interfaces\Models\TermInterface;

class TermEditViewModel extends DynamicViewModel implements TermEditViewModelInterface {
	protected TcaSettingsInterface $tca_settings;
	protected TcaSettingsRepositoryInterface $tca_settings_repository;
	protected TermRepositoryInterface $term_repository;
	
	public function __construct(
		TcaSettingsRepositoryInterface $tca_settings_repository,
		TermRepositoryInterface $term_repository
	) {
		$this->tca_settings_repository = $tca_settings_repository;
		$this->tca_settings = $this->tca_settings_repository->show();
		$this->term_repository = $term_repository;
	}

	/**
	 * @inheritDoc
	 */
	protected function get_view_props( array $data = array() ): array {
		if ( !isset( $data['term'] ) ) {
			return array();
		}
		$term = $data['term'];
		$tca_enabled = $this->tca_settings->is_enabled_for_taxonomy( $term->taxonomy );
		$tca_rules = array();
		if ( $term && $term->get_tca_rules() ) {
			$tca_rules = $term->get_tca_rules()->to_array();
		}
		return array(
			'tca_enabled' => $tca_enabled,
			'tca_rules'   => $tca_rules,
		);
	}
}
