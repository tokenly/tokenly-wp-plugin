<?php

namespace Tokenly\Wp\ViewModels\Admin;

use Tokenly\Wp\Interfaces\Models\Settings\TcaSettingsInterface;
use Tokenly\Wp\Interfaces\Services\Domain\PostServiceInterface;

class PostEditViewModel {
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
		$post_type = get_post_type();
		$tca_enabled = $this->tca_settings->is_enabled_for_post_type( $post_type );
		$post_id = get_the_ID();
		if ( !$post_id || $post_id == 0 ) {
			return;
		}
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
