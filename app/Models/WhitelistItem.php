<?php

namespace Tokenly\Wp\Models;

use Tokenly\Wp\Models\Model;
use Tokenly\Wp\Interfaces\Models\WhitelistItemInterface;

class WhitelistItem extends Model implements WhitelistItemInterface {
	public $address = '';
	public $index = '';
}
