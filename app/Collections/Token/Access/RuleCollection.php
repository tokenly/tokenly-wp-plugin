<?php

/**
 * Collection of TCA rule objects
 */

namespace Tokenly\Wp\Collections\Token\Access;

use Tokenly\Wp\Collections\Collection;
use Tokenly\Wp\Interfaces\Collections\Token\Access\RuleCollectionInterface;

use Tokenly\Wp\Models\Token\Access\Rule;

class RuleCollection extends Collection implements RuleCollectionInterface {
	protected string $item_type = Rule::class;
	
	/**
	 * Formats the TCA rules for request
	 * @return array
	 */
	public function format_rules() {
		$rules = array();
		foreach ( ( array ) $this as $key => $rule ) {
			$rules = array_merge( $rules, $rule->format_rule( $key ) );
		}
		return $rules;
	}

	/**
	 * Generates the hash of the rule
	 * @return string
	 */
	public function to_hash() {
		$rules = serialize( $this->format_rules() );
		$hash = md5( $rules );
		return $hash;
	}
}
