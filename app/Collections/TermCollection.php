<?php

/**
 * Collection of Post objects
 */

namespace Tokenly\Wp\Collections;

use Tokenly\Wp\Collections\Collection;
use Tokenly\Wp\Interfaces\Collections\TermCollectionInterface;
use Tokenly\Wp\Interfaces\Traits\ProtectableInterface;

use Tokenly\Wp\Interfaces\Collections\Token\Access\RuleCheckResultCollectionInterface;
use Tokenly\Wp\Interfaces\Collections\Token\Access\RuleCollectionInterface;
use Tokenly\Wp\Interfaces\Models\Token\Access\VerdictInterface;
use Tokenly\Wp\Models\Term;
use Tokenly\Wp\Interfaces\Models\UserInterface;
use Tokenly\Wp\Traits\ProtectableCollectionTrait;

class TermCollection extends Collection
	implements TermCollectionInterface, ProtectableInterface
{
	use ProtectableCollectionTrait;
	protected string $item_type = Term::class;
}
