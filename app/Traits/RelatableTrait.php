<?php

namespace Tokenly\Wp\Traits;

trait RelatableTrait {
	/**
	 * Formats the relation names by decoupling the root and its relations
	 * which allows to pass them further and load any other nested relations
	 * @param string[] $relations Relations to format
	 * @return string[]
	 */
	protected function format_relation( string $relation ) {
		$has_nested = $this->str_contains( $relation, '.' );
		if ( !$has_nested ) {
			$root = $relation;
			$relations = null;
		} else {
			$relation = explode( '.', $relation );
			$root = $relation[0];
			unset( $relation[0] );
			$relations = implode( '.', $relation );
		}
		return array(
			'root'      => $root,
			'relations' => $relations,
		);
	}

	protected function str_contains($haystack, $needle) {
        return $needle !== '' && mb_strpos($haystack, $needle) !== false;
    }
}
