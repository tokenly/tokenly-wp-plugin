<?php

namespace Tokenly\Wp\Models\Credit;

use Tokenly\Wp\Models\Settings;
use Tokenly\Wp\Interfaces\Models\Credit\GroupWhitelistInterface;

use Tokenly\Wp\Interfaces\Collections\Credit\GroupWhitelistItemCollectionInterface;

class GroupWhitelist extends Settings implements GroupWhitelistInterface {
	public array $items = array();

	/**
	 * @inheritDoc
	 */
	public function from_array( ?array $data = array() ): self {
		return parent::from_array( $data );
	}

	/**
	 * @inheritDoc
	 */
	public function to_array(): array {
		$array = array(
			'items'   => $this->items,
		);
		return $array;
	}

	/**
	 * Checks if the group is whitelisted
	 * @param string $group Group UUID
	 * @return bool
	 */
	public function is_whitelisted( ?string $group ): bool {
		if ( isset ( $this->items[ $group ] ) ) {
			return $this->items[ $group ];
		} else {
			return false;
		}
	}

	/**
	 * @inheritDoc
	 */
	protected function get_fillable(): array {
		return array_merge( parent::get_fillable(), array(
			'items',
		) );
	}
}
