<?php

/**
 * Collection of Category Terms
 */

namespace Tokenly\Wp\Collections\Token;

use Tokenly\Wp\Collections\TermCollection;
use Tokenly\Wp\Interfaces\Collections\Token\CategoryTermCollectionInterface;

use Tokenly\Wp\Models\Token\CategoryTerm;

class CategoryTermCollection extends TermCollection implements CategoryTermCollectionInterface {
	protected string $item_type = CategoryTerm::class;
}
