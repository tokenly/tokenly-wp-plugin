<?php

/**
 * Collection of TCA rule objects
 */

namespace Tokenly\Wp\Collections;

use Tokenly\Wp\Collections\Collection;
use Tokenly\Wp\Interfaces\Collections\WhitelistItemCollectionInterface;
use Tokenly\Wp\Interfaces\Models\WhitelistItemInterface;

class WhitelistItemCollection extends Collection implements WhitelistItemCollectionInterface {
	protected $item_type = WhitelistItemInterface::class;
}
