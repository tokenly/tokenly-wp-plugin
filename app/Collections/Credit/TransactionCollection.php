<?php

/**
 * Collection of transaction objects
 */

namespace Tokenly\Wp\Collections\Credit;

use Tokenly\Wp\Collections\Collection;
use Tokenly\Wp\Interfaces\Collections\Credit\TransactionCollectionInterface;

use Tokenly\Wp\Interfaces\Models\Credit\TransactionInterface;

class TransactionCollection extends Collection implements TransactionCollectionInterface {
	protected $item_type = TransactionInterface::class;
}
