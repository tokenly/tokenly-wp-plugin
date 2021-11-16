<?php

namespace Tokenly\Wp\Factories\Collections;

use Tokenly\Wp\Interfaces\Factories\Collections\PromiseCollectionFactoryInterface;
use Tokenly\Wp\Interfaces\Factories\Models\PromiseFactoryInterface;
use Tokenly\Wp\Interfaces\Collections\PromiseCollectionInterface;
use Tokenly\Wp\Interfaces\Models\PromiseInterface;
use Tokenly\Wp\Factories\Factory;

class PromiseCollectionFactory extends Factory implements PromiseCollectionFactoryInterface {
	protected $promise_factory;

	public function __construct(
		$factory,
		PromiseFactoryInterface $promise_factory
	) {
		parent::__construct( $factory );
		$this->promise_factory = $promise_factory;
	}

	/**
	 * Creates a new collection
	 * @param array $params New collection data
	 * @return PromiseCollectionInterface
	 */
	public function create( $data, $args = array() ) {
		$items = array_map( function( $item_data ) {
			if ( is_a( $item_data, PromiseInterface::class ) === false ) {
				$promise = $this->promise_factory->create( $item_data );
				return $promise;
			} else {
				return $item_data;
			}
		}, $data );
		$collection = $this->factory->create( array(
			'items' => $items,
		) );
		return $collection;
	}
}
