<?php

namespace Tokenly\Wp\Presentation\Views\Admin;

use Tokenly\Wp\Presentation\Views\ViewModel;
use Tokenly\Wp\Interfaces\Presentation\Views\Admin\TermEditViewModelInterface;
use Tokenly\Wp\Interfaces\Models\Settings\TcaSettingsInterface;
use Tokenly\Wp\Interfaces\Services\Domain\TermServiceInterface;

class TermEditViewModel extends ViewModel implements TermEditViewModelInterface {
	protected $tca_settings;
	protected $term_service;
	
	public function __construct(
		TcaSettingsInterface $tca_settings,
		TermServiceInterface $term_service
	) {
		$this->tca_settings = $tca_settings;
		$this->term_service = $term_service;
	}
	
	public function prepare( array $data = array() ) {
		if ( !isset( $data['term'] ) ) {
			return;
		}
		$term = $data['term'];
		$taxonomy = $term->taxonomy;
		$tca_enabled = $this->tca_settings->is_enabled_for_taxonomy( $taxonomy );
		$term_id = $term->term_id;
		$term = $this->term_service->show( array(
			'taxonomy' => $taxonomy,
			'include'  => $term_id,
		) );
		$tca_rules = array();
		if ( $term && isset( $term->tca_rules ) && is_object( $term->tca_rules ) ) {
			$tca_rules = $term->tca_rules->to_array();
		}
		return array(
			'tca_enabled' => $tca_enabled,
			'tca_rules'   => $tca_rules,
		);
	}
}
