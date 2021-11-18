<?php

namespace Tokenly\Wp\Interfaces\Factories;

interface FactoryInterface {
	public function create( $data, $args = array() );
}
