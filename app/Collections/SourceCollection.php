<?php

/**
 * Collection of Source objects
 */

namespace Tokenly\Wp\Collections;

use Tokenly\Wp\Collections\Collection;
use Tokenly\Wp\Interfaces\Collections\SourceCollectionInterface;
use Tokenly\Wp\Interfaces\Models\SourceInterface;
use Tokenly\Wp\Interfaces\Repositories\UserRepositoryInterface;

class SourceCollection extends Collection implements SourceCollectionInterface {
	protected $item_type = SourceInterface::class;
	protected $user_repository;

	public function __construct(
		array $items,
		UserRepositoryInterface $user_repository
	) {
		parent::__construct( $items );
		$this->user_repository = $user_repository;
	}

	/**
	 * Embeds address data
	 * @return void
	 */
	public function with_address() {
		$user = $this->user_repository->show( array(
			'id' => get_current_user_id(),
		) );
		$addresses = $user->get_addresses();
		$addresses->key_by_field( 'address' );
		$with_address = array_map( function( $source ) use ( $addresses ) {
			$address_data = $addresses[ $source->address ] ?? null;
			if ( $address_data ) {
				$source->address_data = $address_data;
			}
			return $source;
		}, ( array ) $this );
		$this->exchangeArray( $with_address );
	}
}
