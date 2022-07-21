<?php

namespace Tokenly\Wp\Collections\Routes\Listings;

use Tokenly\Wp\Collections\Routes\Listings\ColumnCollection;
use Tokenly\Wp\Interfaces\Collections\Routes\Listings\PostColumnCollectionInterface;

use Tokenly\Wp\Models\Routes\Listings\PostColumn;

class PostColumnCollection extends ColumnCollection
	implements PostColumnCollectionInterface
{
	protected string $item_type = PostColumn::class;
}
