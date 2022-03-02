<?php

/**
 * Collection of TCA rule objects
 */

namespace Tokenly\Wp\Collections\Token\Access;

use Tokenly\Wp\Collections\Collection;
use Tokenly\Wp\Interfaces\Collections\Token\Access\RuleCollectionCollectionInterface;

use Tokenly\Wp\Collections\Token\Access\RuleCollection;

class RuleCollectionCollection extends Collection implements RuleCollectionCollectionInterface {
	protected string $item_type = RuleCollection::class;
	
	/**
	 * Keys the TCA rule groups by their rule attribute hash
	 * @return self
	 */
	public function key_by_hash(): self {
		$keyed = array();
		$this->keyed = true;
		foreach ( ( array ) $this as $group ) {
			$keyed[ $group->to_hash() ] = $group;
		}
		$this->exchangeArray( $keyed );
		return $this;
	}
}
