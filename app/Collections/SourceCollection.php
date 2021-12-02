<?php

/**
 * Collection of Source objects
 */

namespace Tokenly\Wp\Collections;

use Tokenly\Wp\Collections\Collection;
use Tokenly\Wp\Interfaces\Collections\SourceCollectionInterface;
use Tokenly\Wp\Interfaces\Models\SourceInterface;

class SourceCollection extends Collection implements SourceCollectionInterface {
	protected $item_type = SourceInterface::class;

	/**
	 * Appends Address objects to the queried sources
	 * @param string[] $relation Relations
	 * @return self
	 */
	protected function load_address( array $relations ) {
		if ( $this->current_user->is_guest() === true ) {
			return $sources;
		}
		$addresses = $this->current_user->get_addresses( array(
			'with' => $relation,
		) );
		$addresses->key_by_field( 'address' );
		foreach ( $sources as &$source ) {
			$address_data = $addresses[ $source->address ] ?? null;
			if ( $address_data ) {
				$source->address_data = $address_data;
			}
		}
		return $sources;
	}
}
