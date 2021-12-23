<?php

/**
 * Collection of Credit account objects
 */

namespace Tokenly\Wp\Collections\Credit;

use Tokenly\Wp\Collections\Collection;
use Tokenly\Wp\Interfaces\Collections\Credit\AccountCollectionInterface;

use Tokenly\Wp\Interfaces\Models\Credit\AccountInterface;

class AccountCollection extends Collection implements AccountCollectionInterface {
	protected $item_type = AccountInterface::class;
}
