<?php

/**
 * Collection of user objects
 */

namespace Tokenly\Wp\Collections;

use Tokenly\Wp\Collections\Collection;
use Tokenly\Wp\Interfaces\Collections\UserCollectionInterface;
use Tokenly\Wp\Interfaces\Models\UserInterface;
use Tokenly\Wp\Interfaces\Repositories\General\UserMetaRepositoryInterface;

class UserCollection extends Collection implements UserCollectionInterface {
	protected $item_type = UserInterface::class;
	protected $user_meta_repository;
	
	public function __construct(
		UserMetaRepositoryInterface $user_meta_repository,
		array $items = array()
	) {
		parent::__construct( $items );
		$this->user_meta_repository = $user_meta_repository;
	}
	
	public function key_by_uuid() {
		$keyed = array();
		foreach ( ( array ) $this as $user ) {
			$uuid = $this->user_meta_repository->show( $user->ID, 'uuid' );
			if ( !$uuid ) {
				continue;
			}
			$keyed[ $uuid ] = $user;
		}
		$this->exchangeArray( $keyed );
	}

	/**
	 * Creates an array of suggestions out of users
	 * (used for real-time search in combobox inputs)
	 * @return array
	 */
	public function to_suggestions() {
		$suggestions = array();
		foreach (  (array ) $this as $user ) {
			$suggestions[] = array(
				'id'   => $user->ID, 
				'name' => $user->user_login,
			);
		}
		return $suggestions;
	}
}
