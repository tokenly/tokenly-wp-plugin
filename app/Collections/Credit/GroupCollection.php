<?php

/**
 * Collection of group objects
 */

namespace Tokenly\Wp\Collections\Credit;

use Tokenly\Wp\Collections\Collection;
use Tokenly\Wp\Interfaces\Collections\Credit\GroupCollectionInterface;

use Tokenly\Wp\Interfaces\Models\Credit\GroupInterface;

class GroupCollection extends Collection implements GroupCollectionInterface {
	protected $item_type = GroupInterface::class;
}
