<?php

namespace Tokenly\Wp\Models;

use Tokenly\Wp\Interfaces\Models\WhitelistItemInterface;

class WhitelistItem implements WhitelistItemInterface {
	public $address = '';
	public $index = '';
	
	public function __construct(
		$whitelist_item_data = array()
	) {
		$this->from_array( $whitelist_item_data );
	}

	public function from_array( $whitelist_item_data ) {
		if ( isset( $whitelist_item_data['address'] ) ) {
			$this->address = $whitelist_item_data['address'];
		}
		if ( isset( $whitelist_item_data['index'] ) ) {
			$this->index = $whitelist_item_data['index'];
		}
		return $this;
	}

	public function to_array() {
		return array(
			'address' => $this->address,
			'index'   => $this->index,
		);
	}
}
