<?php

/**
 * Collection of Address objects
 */

namespace Tokenly\Wp\Collections;

use Tokenly\Wp\Interfaces\Collections\AddressCollectionInterface;
use Tokenly\Wp\Interfaces\Models\AddressInterface;
use Tokenly\Wp\Interfaces\Factories\Models\AddressFactoryInterface;
use Tokenly\Wp\Collections\Collection;

class AddressCollection extends Collection implements AddressCollectionInterface {
	protected $item_type = AddressInterface::class;

	/**
	 * Loads balances for each address
	 * @param array $relation Relations
	 * @return AddressCollectionInterface Modified addresses
	 */
	protected function load_balances( array $relation ) {
		foreach( (array) $this as &$address ) {
			$address->balances = $address->balances->load( $relation );
		}
		return $this;
	}
}
