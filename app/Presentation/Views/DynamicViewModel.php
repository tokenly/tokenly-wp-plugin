<?php

namespace Tokenly\Wp\Presentation\Views;

use Tokenly\Wp\Presentation\Views\ViewModel;
use Tokenly\Wp\Interfaces\Presentation\Views\DynamicViewModelInterface;

class DynamicViewModel extends ViewModel implements DynamicViewModelInterface {
	/**
	 * @inheritDoc
	 */
	public function prepare( array $data = array() ): array {
		$props = array();
		$props_view = $this->get_view_props( $data );
		$props = array_merge( $props, $props_view );
		return $props;
 	}

	/**
	 * Gets the view props
	 * @return array
	 */
	protected function get_view_props(): array {
		return array();
	}
}
