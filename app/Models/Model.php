<?php

namespace Tokenly\Wp\Models;

use Tokenly\Wp\Interfaces\Models\ModelInterface;

class Model implements ModelInterface {
	public function __construct(
		array $data
	) {
		$this->fill( $data );
	}

	public function fill( array $data ) {
		//
	}

	public function to_array() {
		//
	}
}
