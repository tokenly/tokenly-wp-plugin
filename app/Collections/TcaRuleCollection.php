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
	
	/**
	 * Formats the TCA rules for request
	 * @param TcaRuleCollectionInterface $rules
	 * @return array
	 */
	protected function format_rules() {
		$rules = array();
		foreach ( ( array ) $this as $key => $rule ) {
			$rules = array_merge( $rules, $rule->format_rule( $key ) );
		}
		return $rules;
	}
}
