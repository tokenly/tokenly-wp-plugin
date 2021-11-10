<?php

namespace Tokenly\Wp\Models;

use Tokenly\Wp\Interfaces\Models\WhitelistItemInterface;

class WhitelistItem implements WhitelistItemInterface {
	public $address;
	public $index;
	
	public function __construct(
		$whitelist_data = array()
	) {
		$this->address = $whitelist_data['address'] ?? null;
		$this->index = $whitelist_data['index'] ?? null;
	}
}
