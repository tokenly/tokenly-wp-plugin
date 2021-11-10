<?php

namespace Tokenly\Wp\Factories;

use Tokenly\Wp\Interfaces\Factories\WhitelistItemFactoryInterface;
use Tokenly\Wp\Interfaces\Models\WhitelistItemInterface;
use Tokenly\Wp\Factories\Factory;

class WhitelistItemFactory extends Factory implements WhitelistItemFactoryInterface {
	/**
	 * Creates a new user decorator
	 * @param array $params New whitelist item data
	 * @return WhitelistItemInterface
	 */
	public function create( $params ) {
		$instance = $this->factory->create( $params );
		return $instance;
	}
}
