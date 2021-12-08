<?php

/**
 * Collection of Credit account objects
 */

namespace Tokenly\Wp\Collections;

use Tokenly\Wp\Interfaces\Collections\CreditAccountCollectionInterface;
use Tokenly\Wp\Interfaces\Models\CreditAccountInterface;

class CreditAccountCollection extends Collection implements CreditAccountCollectionInterface {
	protected $item_type = CreditAccountInterface::class;
}
