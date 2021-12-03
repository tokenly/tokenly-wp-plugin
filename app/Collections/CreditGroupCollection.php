<?php

/**
 * Collection of Promise objects
 */

namespace Tokenly\Wp\Collections;

use Tokenly\Wp\Interfaces\Collections\CreditGroupCollectionInterface;
use Tokenly\Wp\Interfaces\Models\CreditGroupInterface;

class CreditGroupCollection extends Collection implements CreditGroupCollectionInterface {
	protected $item_type = CreditGroupInterface::class;
}
