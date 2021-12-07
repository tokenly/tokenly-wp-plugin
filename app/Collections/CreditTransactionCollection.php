<?php

/**
 * Collection of Credit transaction objects
 */

namespace Tokenly\Wp\Collections;

use Tokenly\Wp\Interfaces\Collections\CreditTransactionCollectionInterface;
use Tokenly\Wp\Interfaces\Models\CreditTransactionInterface;

class CreditTransactionCollection extends Collection implements CreditTransactionCollectionInterface {
	protected $item_type = CreditTransactionInterface::class;
}
