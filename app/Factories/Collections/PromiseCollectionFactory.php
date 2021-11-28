<?php

namespace Tokenly\Wp\Factories\Collections;

use Tokenly\Wp\Factories\Collections\CollectionFactory;
use Tokenly\Wp\Interfaces\Factories\Collections\PromiseCollectionFactoryInterface;
use Tokenly\Wp\Interfaces\Factories\Models\PromiseFactoryInterface;

class PromiseCollectionFactory extends CollectionFactory implements PromiseCollectionFactoryInterface {
	public function __construct(
		$factory,
		PromiseFactoryInterface $item_factory
	) {
		parent::__construct( $factory, $item_factory );
	}
}
