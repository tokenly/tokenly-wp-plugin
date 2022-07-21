<?php

/**
 * Collection of Source objects
 */

namespace Tokenly\Wp\Collections\Token;

use Tokenly\Wp\Collections\Collection;
use Tokenly\Wp\Interfaces\Collections\Token\SourceCollectionInterface;

use Tokenly\Wp\Models\Token\Source;

class SourceCollection extends Collection
	implements SourceCollectionInterface
{
	protected string $item_type = Source::class;
}
