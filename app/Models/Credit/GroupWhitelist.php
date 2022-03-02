<?php

namespace Tokenly\Wp\Models\Credit;

use Tokenly\Wp\Models\Settings;
use Tokenly\Wp\Interfaces\Models\Credit\GroupWhitelistInterface;

use Tokenly\Wp\Interfaces\Collections\Credit\GroupWhitelistItemCollectionInterface;

class GroupWhitelist extends Settings implements GroupWhitelistInterface {
	protected array $items = array();

	public function get_items(): ?array {
		return $this->items ?? null;
	}

	public function set_items( ?array $items ): void {
		$this->items = $items;
	}

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
			'items'   => $this->get_items(),
		);
		return $array;
	}

	/**
	 * Checks if the group is whitelisted
	 * @param string $group Group UUID
	 * @return bool
	 */
	public function is_whitelisted( ?string $group ): bool {
		if ( isset ( $this->get_items()[ $group ] ) ) {
			return $this->get_items()[ $group ];
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
