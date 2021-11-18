<?php

namespace Tokenly\Wp\Factories\Collections;

use Tokenly\Wp\Interfaces\Factories\Collections\PromiseMetaCollectionFactoryInterface;
use Tokenly\Wp\Interfaces\Factories\Models\PromiseMetaFactoryInterface;
use Tokenly\Wp\Interfaces\Collections\PromiseMetaCollectionInterface;
use Tokenly\Wp\Interfaces\Models\PromiseMetaInterface;
use Tokenly\Wp\Factories\Factory;

class PromiseMetaCollectionFactory extends Factory implements PromiseMetaCollectionFactoryInterface {
	protected $promise_meta_factory;

	public function __construct(
		$factory,
		PromiseMetaFactoryInterface $promise_meta_factory
	) {
		parent::__construct( $factory );
		$this->promise_meta_factory = $promise_meta_factory;
	}

	/**
	 * Creates a new collection
	 * @param array $params New collection data
	 * @return PromiseMetaCollectionInterface
	 */
	public function create( $data, $args = array() ) {
		$items = array_map( function( $item_data ) {
			if ( is_a( $item_data, PromiseMetaInterface::class ) === false ) {
				return $this->promise_meta_factory->create( $item_data );
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
