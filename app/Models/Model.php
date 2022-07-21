<?php

namespace Tokenly\Wp\Models;

use Tokenly\Wp\Interfaces\Models\ModelInterface;

class Model implements ModelInterface {
	public function __construct( array $data = array() ) {
		$this->fill( $data );
	}

	/**
	 * Fills the class properties from an array
	 * @param array $data New data
	 * @return object
	 */
	public function fill( array $data = array() ): self {
		foreach( $data as $key => $value ) {
			if ( !in_array( $key, $this->get_fillable() ) ) {
				continue;
			}
			if ( property_exists( $this, $key ) ) {
				$this->$key = $value;
			}
		}
		return $this;
	}

	public function from_array( array $data = array() ): self {
		$this->fill( $data );
		return $this;
	}

	public function to_array(): array {
		return array();
	}

	/**
	 * Gets a list of fillable properties
	 * @return string[]
	 */
	protected function get_fillable(): array {
		return array();
	}
}
