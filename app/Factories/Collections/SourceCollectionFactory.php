<?php

namespace Tokenly\Wp\Factories\Collections;

use Tokenly\Wp\Interfaces\Factories\Collections\SourceCollectionFactoryInterface;
use Tokenly\Wp\Interfaces\Factories\Models\SourceFactoryInterface;
use Tokenly\Wp\Interfaces\Collections\SourceCollectionInterface;
use Tokenly\Wp\Interfaces\Models\SourceInterface;
use Tokenly\Wp\Factories\Factory;

class SourceCollectionFactory extends Factory implements SourceCollectionFactoryInterface {
	protected $source_factory;

	public function __construct(
		$factory,
		SourceFactoryInterface $source_factory
	) {
		parent::__construct( $factory );
		$this->source_factory = $source_factory;
	}

	/**
	 * Creates a new collection
	 * @param array $params New collection data
	 * @return SourceCollectionInterface
	 */
	public function create( $data, $args = array() ) {
		$items = array_map( function( $item_data ) {
			if ( is_a( $item_data, SourceInterface::class ) === false ) {
				return $this->source_factory->create( $item_data );
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
