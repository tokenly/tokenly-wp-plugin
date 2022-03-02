<?php

/**
 * Collection of Post objects
 */

namespace Tokenly\Wp\Collections;

use Tokenly\Wp\Collections\Collection;
use Tokenly\Wp\Interfaces\Collections\PostCollectionInterface;
use Tokenly\Wp\Interfaces\Traits\ProtectableInterface;

use Tokenly\Wp\Models\Post;
use Tokenly\Wp\Traits\ProtectableCollectionTrait;

class PostCollection extends Collection implements PostCollectionInterface, ProtectableInterface {
	use ProtectableCollectionTrait;
	protected string $item_type = Post::class;
}
