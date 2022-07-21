<?php

/**
 * Collection of Address objects
 */

namespace Tokenly\Wp\Collections\Token;

use Tokenly\Wp\Collections\Collection;
use Tokenly\Wp\Interfaces\Collections\Token\AddressCollectionInterface;

use Tokenly\Wp\Models\Token\Address;
use Tokenly\Wp\Interfaces\Collections\Token\SourceCollectionInterface;

class AddressCollection extends Collection
	implements AddressCollectionInterface
{
	protected string $item_type = Address::class;

	public function filter_registered( SourceCollectionInterface $sources ) {
		$sources = clone $sources;
		$sources = $sources->key_by_field( 'address_id' );
		foreach ( ( array ) $this as $key => &$address ) {
			if ( isset( $sources[ $address->address ] ) ) {
				unset( $this[ $key ] );
			}
		}
	}
}
