<?php

/**
 * Collection of Address objects
 */

namespace Tokenly\Wp\Collections\Token;

use Tokenly\Wp\Collections\Collection;
use Tokenly\Wp\Interfaces\Collections\Token\AddressCollectionInterface;

use Tokenly\Wp\Interfaces\Models\Token\AddressInterface;
use Tokenly\Wp\Interfaces\Services\Domain\Token\SourceServiceInterface;

class AddressCollection extends Collection implements AddressCollectionInterface {
	protected $item_type = AddressInterface::class;
	protected $source_service;
	
	public function __construct(
		SourceServiceInterface $source_service,
		array $items
	) {
		$this->source_service = $source_service;
		parent::__construct( $items );
	}

	public function filter_registered() {
		$sources = clone $this->source_service->index();
		$sources = $sources->key_by_field( 'address_id' );
		foreach ( ( array ) $this as $key => &$address ) {
			if ( isset( $sources[ $address->address ] ) ) {
				unset( $this[ $key ] );
			}
		}
	}
	
	/**
	 * Loads the balance relation
	 * @param string[] $relations Further relations
	 * @return self
	 */
	protected function load_balance( array $relations ) {
		foreach( (array) $this as &$address ) {
			$address->balance = $address->balance->load( $relations );
		}
		return $this;
	}
}
