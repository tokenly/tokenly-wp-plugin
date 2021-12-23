<?php

/**
 * Collection of meta objects
 */

namespace Tokenly\Wp\Collections\Token;

use Tokenly\Wp\Collections\Collection;
use Tokenly\Wp\Interfaces\Collections\Token\MetaCollectionInterface;

use Tokenly\Wp\Interfaces\Models\Token\MetaInterface;

class MetaCollection extends Collection implements MetaCollectionInterface {
	protected $item_type = MetaInterface::class;
}
