<?php

namespace Tokenly\Wp\Factories\Collections;

use Tokenly\Wp\Factories\Collections\CollectionFactory;
use Tokenly\Wp\Interfaces\Factories\Collections\AddressCollectionFactoryInterface;
use Tokenly\Wp\Interfaces\Factories\Models\AddressFactoryInterface;

class AddressCollectionFactory extends CollectionFactory implements AddressCollectionFactoryInterface {
	public function __construct(
		$factory,
		AddressFactoryInterface $item_factory
	) {
		parent::__construct( $factory, $item_factory );
	}
}
