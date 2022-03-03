<?php

/**
 * Collection of meta objects
 */

namespace Tokenly\Wp\Collections\Token;

use Tokenly\Wp\Collections\PostCollection;
use Tokenly\Wp\Interfaces\Collections\Token\MetaCollectionInterface;

use Tokenly\Wp\Models\Token\Meta;
use Tokenly\Wp\Interfaces\Collections\Token\CategoryTermCollectionInterface;

class MetaCollection extends PostCollection implements MetaCollectionInterface {
	protected string $item_type = Meta::class;

	public function append_fallback( string $taxonomy, CategoryTermCollectionInterface $categories ): self {
		foreach ( ( array ) $this as $item ) {
			$item->append_fallback( $taxonomy, $categories );
		}
		return $this;
	}
}
