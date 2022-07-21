<?php

/**
 * Collection of TCA rule objects
 */

namespace Tokenly\Wp\Collections\Token;

use Tokenly\Wp\Collections\Collection;
use Tokenly\Wp\Interfaces\Collections\Token\WhitelistItemCollectionInterface;

use Tokenly\Wp\Models\Token\WhitelistItem;

class WhitelistItemCollection extends Collection
	implements WhitelistItemCollectionInterface
{
	protected string $item_type = WhitelistItem::class;
}
