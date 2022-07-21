<?php

namespace Tokenly\Wp\Collections\Routes\Listings;

use Tokenly\Wp\Collections\Routes\Listings\ColumnCollection;
use Tokenly\Wp\Interfaces\Collections\Routes\Listings\UserColumnCollectionInterface;

use Tokenly\Wp\Models\Routes\Listings\UserColumn;

class UserColumnCollection extends ColumnCollection
	implements UserColumnCollectionInterface
{
	protected string $item_type = UserColumn::class;
}
