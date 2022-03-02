<?php

/**
 * Collection of Credit account objects
 */

namespace Tokenly\Wp\Collections\Credit;

use Tokenly\Wp\Collections\Collection;
use Tokenly\Wp\Interfaces\Collections\Credit\AccountCollectionInterface;

use Tokenly\Wp\Models\Credit\Account;

class AccountCollection extends Collection implements AccountCollectionInterface {
	protected string $item_type = Account::class;
}
