<?php

/**
 * Collection of transaction objects
 */

namespace Tokenly\Wp\Collections\Credit;

use Tokenly\Wp\Collections\Collection;
use Tokenly\Wp\Interfaces\Collections\Credit\TransactionCollectionInterface;

use Tokenly\Wp\Models\Credit\Transaction;

class TransactionCollection extends Collection implements TransactionCollectionInterface {
	protected string $item_type = Transaction::class;
}
