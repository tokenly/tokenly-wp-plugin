<?php

namespace Tokenly\Wp\Models;

use Tokenly\Wp\Interfaces\Models\TcaSettingsInterface;
use Tokenly\Wp\Interfaces\Services\Domain\TcaSettingsServiceInterface;

class TcaSettings implements TcaSettingsInterface {
	public $post_types = array();
	protected $tca_settings_service;
	
	public function __construct(
		$settings_data = array(),
		TcaSettingsServiceInterface $tca_settings_service
	) {
		$this->from_array( $settings_data );
		$this->tca_settings_service = $tca_settings_service;
	}

	public function save() {
		$save_data = $this->to_array();
		$this->tca_settings_service->update( $save_data );
	}

	public function update( $settings_data ) {
		$this->from_array( $settings_data );
		$this->save();
	}

	public function from_array( $settings_data ) {
		if ( isset( $settings_data['post_types'] ) ) {
			$this->post_types = $settings_data['post_types'];
		}
		return $this;
	}

	public function is_enabled_for_post_type( string $post_type ) {
		return $this->post_types[ $post_type ] ?? false;
	}

	public function to_array() {
		return array(
			'post_types' => $this->post_types,
		);
	}
}
