<?php

namespace Tokenly\Wp\Factories\Collections;

use Tokenly\Wp\Factories\Collections\CollectionFactory;
use Tokenly\Wp\Interfaces\Factories\Collections\TokenMetaCollectionFactoryInterface;
use Tokenly\Wp\Interfaces\Factories\Models\TokenMetaFactoryInterface;

class TokenMetaCollectionFactory extends CollectionFactory implements TokenMetaCollectionFactoryInterface {
	public function __construct(
		$factory,
		TokenMetaFactoryInterface $item_factory
	) {
		parent::__construct( $factory, $item_factory );
	}
}
