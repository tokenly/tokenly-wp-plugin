<?php

/**
 * Collection of user objects
 */

namespace Tokenly\Wp\Collections;

use Tokenly\Wp\Collections\Collection;
use Tokenly\Wp\Interfaces\Collections\UserCollectionInterface;

use Tokenly\Wp\Models\User;

class UserCollection extends Collection implements UserCollectionInterface {
	protected string $item_type = User::class;
	
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
