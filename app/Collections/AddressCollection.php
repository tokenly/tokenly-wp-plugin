<?php

/**
 * Collection of Address objects
 */

namespace Tokenly\Wp\Collections;

use Tokenly\Wp\Interfaces\Collections\AddressCollectionInterface;
use Tokenly\Wp\Interfaces\Models\AddressInterface;
use Tokenly\Wp\Interfaces\Factories\Models\AddressFactoryInterface;
use Tokenly\Wp\Collections\Collection;
use Tokenly\Wp\Interfaces\Factories\Collections\BalanceCollectionFactoryInterface;

class AddressCollection extends Collection implements AddressCollectionInterface {
	protected $item_type = AddressInterface::class;
	protected $balance_collection_factory;
	
	public function __construct(
		BalanceCollectionFactoryInterface $balance_collection_factory,
		array $items
	) {
		$this->balance_collection_factory = $balance_collection_factory;
		parent::__construct( $items );
	}
	
	/**
	 * Loads the balance relation
	 * @param array $relations Further relations
	 * @return self
	 */
	protected function load_balance( array $relations ) {
		foreach( (array) $this as &$address ) {
			$address->balance = $address->balance->load( $relations );
		}
		return $this;
	}
	
	public function get_combined_balance() {
		$balances = array();
		foreach ( ( array ) $this as $address ) {
			$balances = array_merge( $balances, ( array ) $address->balance );
		}
		$balances = $this->balance_collection_factory->create( $balances );
		return $balances;
	}
}
