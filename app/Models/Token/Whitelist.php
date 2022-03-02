<?php

namespace Tokenly\Wp\Models\Token;

use Tokenly\Wp\Models\Settings;
use Tokenly\Wp\Interfaces\Models\Token\WhitelistInterface;

use Tokenly\Wp\Collections\Token\WhitelistItemCollection;
use Tokenly\Wp\Interfaces\Collections\Token\WhitelistItemCollectionInterface;

class Whitelist extends Settings implements WhitelistInterface {
	protected ?bool $enabled = false;
	protected ?WhitelistItemCollectionInterface $items;

	public function get_enabled(): ?bool {
		return $this->enabled ?? null;
	}

	public function set_enabled( ?bool $value ): void {
		$this->enabled = $value;
	}

	public function get_items(): ?WhitelistItemCollectionInterface {
		return $this->items;
	}

	public function set_items( ?WhitelistItemCollectionInterface $value ): void {
		$this->items = $value;
	}

	/**
	 * @inheritDoc
	 */
	public function from_array( array $data = array() ): self {
		if ( isset( $data['items'] ) && is_array( $data['items'] ) ) {
			$data['items'] = ( new WhitelistItemCollection() )->from_array( $data['items'] );
		}
		return parent::from_array( $data );
	}

	/**
	 * @inheritDoc
	 */
	public function to_array(): array {
		$array = array(
			'enabled' => $this->get_enabled(),
			'items'   => $this->get_items()->to_array(),
		);
		return $array;
	}

	/**
	 * @inheritDoc
	 */
	protected function get_fillable(): array {
		return array_merge( parent::get_fillable(), array(
			'enabled',
			'items',
		) );
	}
}
