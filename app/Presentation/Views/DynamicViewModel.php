<?php

namespace Tokenly\Wp\Presentation\Views;

use Tokenly\Wp\Presentation\Views\ViewModel;
use Tokenly\Wp\Interfaces\Presentation\Views\DynamicViewModelInterface;

class DynamicViewModel extends ViewModel implements DynamicViewModelInterface {
	public function prepare( array $data = array() ) {
		$props = array();
		$props_shared = $this->get_shared_data();
		$props_view = $this->get_view_props( $data );
		$props = array_merge( $props, $props_shared, $props_view );
		return $props;
 	}

	protected function get_view_props() {
		return array();
	}

	protected function get_shared_data() {
		return array(
			'nonce' =>  wp_create_nonce( 'wp_rest' ),
		);
	}
}
