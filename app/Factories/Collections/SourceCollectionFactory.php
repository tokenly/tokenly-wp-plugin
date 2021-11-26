<?php

namespace Tokenly\Wp\Factories\Collections;

use Tokenly\Wp\Factories\Collections\CollectionFactory;
use Tokenly\Wp\Interfaces\Factories\Collections\SourceCollectionFactoryInterface;
use Tokenly\Wp\Interfaces\Factories\Models\SourceFactoryInterface;

class SourceCollectionFactory extends CollectionFactory implements SourceCollectionFactoryInterface {
	public function __construct(
		$factory,
		SourceFactoryInterface $item_factory
	) {
		parent::__construct( $factory, $item_factory );
	}
}
