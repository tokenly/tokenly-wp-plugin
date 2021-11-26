<?php

namespace Tokenly\Wp\Factories\Collections;

use Tokenly\Wp\Factories\Collections\CollectionFactory;
use Tokenly\Wp\Interfaces\Factories\Collections\TcaRuleCollectionFactoryInterface;
use Tokenly\Wp\Interfaces\Factories\Models\TcaRuleFactoryInterface;

class TcaRuleCollectionFactory extends CollectionFactory implements TcaRuleCollectionFactoryInterface {
	public function __construct(
		$factory,
		TcaRuleFactoryInterface $item_factory
	) {
		parent::__construct( $factory, $item_factory );
	}
}
