<?php

/**
 * Collection of Token meta objects
 */

namespace Tokenly\Wp\Collections;

use Tokenly\Wp\Collections\Collection;
use Tokenly\Wp\Interfaces\Collections\TokenMetaCollectionInterface;
use Tokenly\Wp\Interfaces\Models\TokenMetaInterface;

class TokenMetaCollection extends Collection implements TokenMetaCollectionInterface {
	protected $item_type = TokenMetaInterface::class;
}
