<?php

namespace Tokenly\Wp\Collections\Routes\Listings;

use Tokenly\Wp\Collections\Routes\Listings\ColumnCollection;
use Tokenly\Wp\Interfaces\Collections\Routes\Listings\TermColumnCollectionInterface;

use Tokenly\Wp\Models\Routes\Listings\TermColumn;

class TermColumnCollection extends ColumnCollection implements TermColumnCollectionInterface {
	protected string $item_type = TermColumn::class;
}
