<?php

namespace Tokenly\Wp\Factories\Collections;

use Tokenly\Wp\Interfaces\Factories\Collections\CollectionFactoryInterface;

class CollectionFactory implements CollectionFactoryInterface {
	protected $factory;
	protected $item_factory;
	public $class;

	public function __construct(
		$factory,
		$item_factory
	) {
		$this->factory = $factory;
		$this->item_factory = $item_factory;
		$this->class = $item_factory->class;
	}

	/**
	 * Creates a new collection
	 * @param array $data New collection data
	 * @param array $args Additional arguments
	 * @return mixed
	 */
	public function create( $data, $args = array() ) {
		foreach ( $data as &$item ) {
			if ( is_a( $item, $this->class ) === false ) {
				$item = $this->item_factory->create( $item );
			}
		};
		$collection = $this->factory->create( array(
			'items' => $data,
		) );
		return $collection;
	}
}
