<?php

namespace Tokenly\Wp\Traits;

use Tokenly\Wp\Collections\Token\Access\RuleCollection;
use Tokenly\Wp\Collections\Token\Access\RuleCollectionCollection;
use Tokenly\Wp\Interfaces\Collections\Token\Access\RuleCollectionInterface;
use Tokenly\Wp\Interfaces\Collections\Token\Access\RuleCollectionCollectionInterface;

trait ProtectableCollectionTrait {
    public function __get( $name ) {
		if ( $name == 'tca_rules' ) {
			return $this->get_tca_rules();
		}
    }

	protected function get_tca_rules(): RuleCollectionCollectionInterface {
		$rules = new RuleCollectionCollection();
		foreach ( ( array ) $this as $item ) {
			$item_rules = $item->tca_rules;
			if ( $item_rules ) {
				$rules[] = $item_rules;
			}
		}
		return $rules;
	}
}
