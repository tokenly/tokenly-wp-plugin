<?php

namespace Tokenly\Wp\Factories\Collections;

use Tokenly\Wp\Interfaces\Factories\Collections\TokenMetaCollectionFactoryInterface;
use Tokenly\Wp\Interfaces\Factories\Models\TokenMetaFactoryInterface;
use Tokenly\Wp\Interfaces\Collections\TokenMetaCollectionInterface;
use Tokenly\Wp\Interfaces\Models\TokenMetaInterface;
use Tokenly\Wp\Factories\Factory;

class TokenMetaCollectionFactory extends Factory implements TokenMetaCollectionFactoryInterface {
	protected $token_meta_factory;

	public function __construct(
		$factory,
		TokenMetaFactoryInterface $token_meta_factory
	) {
		parent::__construct( $factory );
		$this->token_meta_factory = $token_meta_factory;
	}

	/**
	 * Creates a new collection
	 * @param array $params New collection data
	 * @return TokenMetaCollectionInterface
	 */
	public function create( $data, $args = array() ) {
		$items = array_map( function( $item_data ) {
			if ( is_a( $item_data, TokenMetaInterface::class ) === false ) {
				return $this->token_meta_factory->create( $item_data );
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
