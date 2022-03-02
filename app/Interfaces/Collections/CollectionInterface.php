<?php

namespace Tokenly\Wp\Interfaces\Collections;

interface CollectionInterface {
	public function fill( array $items = array() ): self;
	public function from_array( array $data = array() ): self;
	public function to_array(): array;
	public function key_by_field( string $field );
}
