<?php

/**
 * Collection of Promise objects
 */

namespace Tokenly\Wp\Collections;

use Tokenly\Wp\Interfaces\Collections\PromiseCollectionInterface;
use Tokenly\Wp\Interfaces\Models\PromiseInterface;
use Tokenly\Wp\Collections\Collection;

class PromiseCollection extends Collection implements PromiseCollectionInterface {
	protected $item_type = PromiseInterface::class;
}
