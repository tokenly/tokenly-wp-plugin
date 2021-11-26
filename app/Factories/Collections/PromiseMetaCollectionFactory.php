<?php

namespace Tokenly\Wp\Factories\Collections;

use Tokenly\Wp\Factories\Collections\CollectionFactory;
use Tokenly\Wp\Interfaces\Factories\Collections\PromiseMetaCollectionFactoryInterface;
use Tokenly\Wp\Interfaces\Factories\Models\PromiseMetaFactoryInterface;

class PromiseMetaCollectionFactory extends CollectionFactory implements PromiseMetaCollectionFactoryInterface {
	public function __construct(
		$factory,
		PromiseMetaFactoryInterface $item_factory
	) {
		parent::__construct( $factory, $item_factory );
	}
}
