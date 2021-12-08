<?php

/**
 * Collection of Post objects
 */

namespace Tokenly\Wp\Collections;

use Tokenly\Wp\Interfaces\Collections\PostCollectionInterface;
use Tokenly\Wp\Interfaces\Models\PostInterface;
use Tokenly\Wp\Collections\Collection;

class PostCollection extends Collection implements PostCollectionInterface {
	protected $item_type = PostInterface::class;
}
