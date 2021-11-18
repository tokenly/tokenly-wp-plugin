<?php

namespace Tokenly\Wp\Factories\Collections;

use Tokenly\Wp\Interfaces\Factories\Collections\UserCollectionFactoryInterface;
use Tokenly\Wp\Interfaces\Factories\Models\UserFactoryInterface;
use Tokenly\Wp\Interfaces\Collections\UserCollectionInterface;
use Tokenly\Wp\Interfaces\Models\UserInterface;
use Tokenly\Wp\Factories\Factory;

class UserCollectionFactory extends Factory implements UserCollectionFactoryInterface {
	protected $user_factory;

	public function __construct(
		$factory,
		UserFactoryInterface $user_factory
	) {
		parent::__construct( $factory );
		$this->user_factory = $user_factory;
	}

	/**
	 * Creates a new collection
	 * @param array $params New collection data
	 * @return UserCollectionInterface
	 */
	public function create( $data, $args = array() ) {
		$items = array_map( function( $item_data ) {
			if ( is_a( $item_data, UserInterface::class ) === false ) {
				return $this->user_factory->create( $item_data );
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
