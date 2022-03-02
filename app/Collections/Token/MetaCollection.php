<?php

/**
 * Collection of meta objects
 */

namespace Tokenly\Wp\Collections\Token;

use Tokenly\Wp\Collections\PostCollection;
use Tokenly\Wp\Interfaces\Collections\Token\MetaCollectionInterface;

use Tokenly\Wp\Models\Token\Meta;

class MetaCollection extends PostCollection implements MetaCollectionInterface {
	protected string $item_type = Meta::class;
}
