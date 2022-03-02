<?php

namespace Tokenly\Wp\Presentation;

use Tokenly\Wp\Interfaces\Presentation\PresentationModelInterface;

class PresentationModel implements PresentationModelInterface {
	/**
	 * Prepares the view model
	 * @param array $data View model input data
	 * @return array|null
	 */
	public function prepare( array $data = array() ): ?array {
		//
	}
}
