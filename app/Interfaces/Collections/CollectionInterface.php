<?php

namespace Tokenly\Wp\Interfaces\Collections;

interface CollectionInterface {
	public function fill( array $items );
	public function key_by_field( string $field );
	public function load( array $relations = array() );
	public function to_array();
}
