<?php

namespace Tokenly\Wp\Factories\Collections;

use Tokenly\Wp\Factories\Collections\CollectionFactory;
use Tokenly\Wp\Interfaces\Factories\Collections\UserCollectionFactoryInterface;
use Tokenly\Wp\Interfaces\Factories\Models\UserFactoryInterface;

class UserCollectionFactory extends CollectionFactory implements UserCollectionFactoryInterface {
	public function __construct(
		$factory,
		UserFactoryInterface $item_factory
	) {
		parent::__construct( $factory, $item_factory );
	}
}
