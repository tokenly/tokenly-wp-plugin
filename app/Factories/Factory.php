<?php

namespace Tokenly\Wp\Factories;

use Tokenly\Wp\Interfaces\Factories\FactoryInterface;

class Factory implements FactoryInterface {
	protected $factory;
	public $class;

	public function __construct( $factory ) {
		$this->factory = $factory;
		$this->class = $this->factory->class;
	}

	public function create( $data, $args = array() ) {
		//
	} 
}
