<?php

/**
 * Collection of group objects
 */

namespace Tokenly\Wp\Collections\Credit;

use Tokenly\Wp\Collections\Collection;
use Tokenly\Wp\Interfaces\Collections\Credit\GroupCollectionInterface;

use Tokenly\Wp\Models\Credit\Group;
use Tokenly\Wp\Interfaces\Models\Credit\GroupWhitelistInterface;

class GroupCollection extends Collection implements GroupCollectionInterface {
	protected string $item_type = Group::class;

	/**
	 * Excludes the items which do not have the matching client ID
	 * in the whitelist field
	 * @return self
	 */
	public function exclude_not_valid_clients( string $client_id ): self {
		foreach ( ( array ) $this as $key => $item ) {
			$app_whitelist = $item->get_app_whitelist();
			if ( !in_array( $client_id, $app_whitelist ) ) {
				unset( $this[ $key ] );
			}
		}
		return $this;
	}

	/**
	 * Excludes the items which are not allowed in the Group Whitelist
	 * in the whitelist field
	 * @param GroupWhitelistInterface $whitelist
	 * @return self
	 */
	public function exclude_not_whitelisted( GroupWhitelistInterface $whitelist ): self {
		foreach ( ( array ) $this as $key => $item ) {
			if ( $whitelist->is_whitelisted( $item->get_uuid() ) === false ) {
				unset( $this[ $key ] );
			}
		}
		return $this;
	}
}
