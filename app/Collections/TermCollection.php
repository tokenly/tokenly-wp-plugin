<?php

/**
 * Collection of Post objects
 */

namespace Tokenly\Wp\Collections;

use Tokenly\Wp\Interfaces\Collections\TermCollectionInterface;
use Tokenly\Wp\Interfaces\Models\TermInterface;
use Tokenly\Wp\Collections\Collection;

class TermCollection extends Collection implements TermCollectionInterface {
	protected $item_type = TermInterface::class;
}
