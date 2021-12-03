<?php

namespace Tokenly\Wp\Interfaces\Models;

interface ModelInterface {
	public function fill( array $data = array() );
	public function load( array $relations = array() );
	public function to_array();
	public function update( array $data = array() );
	public function save();
}
