<?php

namespace Tokenly\Wp\Models\Token;

use Tokenly\Wp\Models\Settings;
use Tokenly\Wp\Interfaces\Models\Token\WhitelistInterface;

use Tokenly\Wp\Collections\Token\WhitelistItemCollection;
use Tokenly\Wp\Interfaces\Collections\Token\WhitelistItemCollectionInterface;

class Whitelist extends Settings implements WhitelistInterface {
	public ?bool $enabled = false;
	public ?WhitelistItemCollectionInterface $items = null;

	/**
	 * @inheritDoc
	 */
	public function from_array( array $data = array() ): self {
		if ( isset( $data['items'] ) && is_array( $data['items'] ) ) {
			$data['items'] = ( new WhitelistItemCollection() )->from_array(
				$data['items']
			);
		}
		return parent::from_array( $data );
	}

	/**
	 * @inheritDoc
	 */
	public function to_array(): array {
		$array = array(
			'enabled' => $this->enabled,
			'items'   => $this->items->to_array(),
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
