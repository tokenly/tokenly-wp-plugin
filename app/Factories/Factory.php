<?php

namespace Tokenly\Wp\Factories;

use Tokenly\Wp\Interfaces\Factories\FactoryInterface;

class Factory implements FactoryInterface {
	protected $factory;

	public function __construct( $factory ) {
		$this->factory = $factory;
	}

	public function create( $params ) {
		//
	} 
}
