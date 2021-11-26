<?php

/**
 * Collection of Source objects
 */

namespace Tokenly\Wp\Collections;

use Tokenly\Wp\Collections\Collection;
use Tokenly\Wp\Interfaces\Collections\SourceCollectionInterface;
use Tokenly\Wp\Interfaces\Models\SourceInterface;

class SourceCollection extends Collection implements SourceCollectionInterface {
	protected $item_type = SourceInterface::class;
}
