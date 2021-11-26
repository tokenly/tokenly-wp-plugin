<?php

/**
 * Collection of TCA rule objects
 */

namespace Tokenly\Wp\Collections;

use Tokenly\Wp\Collections\Collection;
use Tokenly\Wp\Interfaces\Collections\TcaRuleCollectionInterface;
use Tokenly\Wp\Interfaces\Models\TcaRuleInterface;

class TcaRuleCollection extends Collection implements TcaRuleCollectionInterface {
	protected $item_type = TcaRuleInterface::class;
}
