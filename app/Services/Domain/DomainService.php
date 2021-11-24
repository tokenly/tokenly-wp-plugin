<?php

namespace Tokenly\Wp\Services\Domain;

use Tokenly\Wp\Interfaces\Services\Domain\DomainServiceInterface;

class DomainService implements DomainServiceInterface {
	protected function format_relations( array $relations ) {
		$relations_formatted = array();
		foreach ( $relations as $relation ) {
			$relation = explode( '.', $relation );
			$relation_parent = $relation[0] ?? null;
			if ( count( $relation ) > 1 ) {
				unset( $relation[0] );
				$relation = implode( '.', $relation );
			} else {
				$relation = $relation[0];
			}
			$relations_formatted[ $relation_parent ] = $relation;
		}
		return $relations_formatted;
	}
}
