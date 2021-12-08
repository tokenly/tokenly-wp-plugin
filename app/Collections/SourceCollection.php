<?php

/**
 * Collection of Source objects
 */

namespace Tokenly\Wp\Collections;

use Tokenly\Wp\Collections\Collection;
use Tokenly\Wp\Interfaces\Collections\SourceCollectionInterface;
use Tokenly\Wp\Interfaces\Models\SourceInterface;
use Tokenly\Wp\Interfaces\Services\Domain\AddressServiceInterface;

class SourceCollection extends Collection implements SourceCollectionInterface {
	protected $item_type = SourceInterface::class;
	protected $address_service;

	public function __construct(
		AddressServiceInterface $address_service,
		array $items
	) {
		parent::__construct( $items );
		$this->address_service = $address_service;
	}

	/**
	 * Loads the address relation
	 * @param string[] $relation Further relations
	 * @return self
	 */
	// protected function load_address( array $relations = array() ) {
	// 	$source_addresses = array_map( function( SourceInterface $source ) {
	// 		return $source->address;	
	// 	}, ( array ) $this );
	// 	$addresses = $this->address_service->index( array(
	// 		'addresses' => $source_addresses,
	// 		'with'    => $relations,
	// 	) );
	// 	if ( $address ) {
	// 		$this->address_data = $address;
	// 	}
	// 	$addresses->key_by_field( 'address' );
	// 	foreach ( $sources as &$source ) {
	// 		$address_data = $addresses[ $source->address ] ?? null;
	// 		if ( $address_data ) {
	// 			$source->address_data = $address_data;
	// 		}
	// 	}
	// 	return $sources;
	// }
}
