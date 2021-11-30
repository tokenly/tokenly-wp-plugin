<?php

namespace Tokenly\Wp\Services\Domain;

use Tokenly\Wp\Interfaces\Services\Domain\DomainServiceInterface;
use Tokenly\Wp\Interfaces\Collections\CollectionInterface;
use Tokenly\Wp\Services\Service;

/**
 * Provides the base functions for the other domain services
 */
class DomainService extends Service implements DomainServiceInterface {
	/**
	 * Formats the relation names by decoupling the root and its relations
	 * which allows to pass them further and load any other nested relations
	 * @param string[] $relations Relations to format
	 * @return string[]
	 */
	protected function format_relations( array $relations ) {
		$relations_formatted = array();
		foreach ( $relations as $relation ) {
			$relation = explode( '.', $relation );
			$relation_parent = $relation[0] ?? null;
			if ( count( $relation ) > 1 ) {
				unset( $relation[0] );
				$relation = implode( '.', $relation );
			} else {
				$relation = null;
			}
			$relations_formatted[ $relation_parent ] = $relation;
		}
		return $relations_formatted;
	}

	/**
	 * Loads the specified relations for the specified item
	 * @param mixed $item Target item
	 * @param array $relations List of relations to load
	 * @return mixed 
	 */
	public function load( $item, array $relations ) {
		$relations = $this->format_relations( $relations );
		foreach ( $relations as $key => $relation ) {
			$load_relations = array();
			if ( !empty( $relation ) ) {
				$load_relations = array( $relation );
			}
			$load_function = "load_{$key}";
			if ( $item instanceof CollectionInterface ) {
				$load_function = "{$load_function}_collection";
			}
			$item = call_user_func( array( $this, $load_function ), $item, $load_relations );
		}
		return $item;
	}
}
