<?php

namespace Tokenly\Wp\Presentation\Views\Admin;

use Tokenly\Wp\Presentation\Views\ViewModel;
use Tokenly\Wp\Interfaces\Presentation\Views\Admin\TaxonomyEditViewModelInterface;
use Tokenly\Wp\Interfaces\Models\Settings\TcaSettingsInterface;
use Tokenly\Wp\Interfaces\Services\Domain\PostServiceInterface;

class TaxonomyEditViewModel extends ViewModel implements TaxonomyEditViewModelInterface {
	protected $tca_settings;
	protected $post_service;
	
	public function __construct(
		TcaSettingsInterface $tca_settings,
		PostServiceInterface $post_service
	) {
		$this->tca_settings = $tca_settings;
		$this->post_service = $post_service;
	}
	
	public function prepare( array $data = array() ) {
		$taxonomy = get_query_var( 'taxonomy' );
		$tca_enabled = $this->tca_settings->is_enabled_for_taxonomy( $taxonomy );
		$tag_id = get_query_var( 'tag_ID' );
		$post = $this->post_service->show( array(
			'id' => $post_id,
		) );
		$tca_rules = array();
		if ( $post && isset( $post->tca_rules ) && is_object( $post->tca_rules ) ) {
			$tca_rules = $post->tca_rules->to_array();
		}
		return array(
			'tca_enabled' => $tca_enabled,
			'tca_rules'   => $tca_rules,
		);
	}
}
