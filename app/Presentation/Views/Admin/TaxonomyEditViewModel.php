<?php

namespace Tokenly\Wp\Presentation\Views\Admin;

use Tokenly\Wp\Presentation\Views\ViewModel;
use Tokenly\Wp\Interfaces\Presentation\Views\Admin\TaxonomyEditViewModelInterface;
use Tokenly\Wp\Interfaces\Models\Settings\TcaSettingsInterface;
use Tokenly\Wp\Interfaces\Services\Domain\TermServiceInterface;

class TaxonomyEditViewModel extends ViewModel implements TaxonomyEditViewModelInterface {
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
		$taxonomy = get_query_var( 'taxonomy' );
		$tca_enabled = $this->tca_settings->is_enabled_for_taxonomy( $taxonomy );
		$tag_id = get_query_var( 'tag_ID' );
		error_log('edit');
		$term = $this->term_service->show( array(
			'taxonomy' => $taxonomy,
			'id'       => $tag_id,
		) );
		error_log( d( $term ) );
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
