<?php

namespace Tokenly\Wp\Collections\Routes\Listings;

use Tokenly\Wp\Collections\Collection;
use Tokenly\Wp\Interfaces\Collections\Routes\Listings\ColumnCollectionInterface;

use Tokenly\Wp\Models\Routes\Listings\Column;

class ColumnCollection extends Collection implements ColumnCollectionInterface {
	protected string $item_type = Column::class;
}
