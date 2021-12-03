<?php

/**
 * Collection base class
 */

namespace Tokenly\Wp\Collections;

use Tokenly\Wp\Interfaces\Collections\CollectionInterface;
use Tokenly\Wp\Traits\RelatableTrait;

class Collection extends \ArrayObject implements CollectionInterface {
	use RelatableTrait;

	protected $item_type;
	protected $domain_service;

	public function __construct( array $items ) {
		$this->fill( $items );
	}

	public function fill( array $items ) {
		foreach ( $items as $item )
		{
			if ($item instanceof $this->item_type === FALSE )
			{
				throw new Exception("Cannot append non " . $this->item_type . " to collection");
			}
		}
		$this->exchangeArray( $items );
	}

	/**
	 * Converts the collection to array
	 * @return array
	 */
	public function to_array() {
		$array = array_map( function( $item ) {
			return $item->to_array();
		}, ( array ) $this );
		return $array;
	}

	public function key_by_field( string $field ) {
		$keyed = array();
		foreach ( ( array ) $this as $item ) {
			$keyed[ $item->$field ] = $item;
		}
		$this->exchangeArray( $keyed );
		return $this;
	}

	/**
	 * Loads the specified relations
	 * @param array $relations List of relations to load
	 * @return self
	 */
	public function load( array $relations = array() ) {
		$relations_formatted = $this->format_relations( $relations );
		foreach ( $relations_formatted as $key => $relation ) {
			$load_relations = array();
			if ( !empty( $relation ) ) {
				$load_relations = array( $relation );
			}
			if ( isset( $this[ $key ] ) ) {
				$this[ $key ]->load( array( $load_relations ) );
				continue;
			}
			$method = "load_{$key}";
			if ( method_exists( $this, $method ) ) {
				call_user_func( array( $this, $method ), $load_relations );
			} else {
				foreach ( (array) $this as $item ) {
					$load_relations = $key;
					if ( !empty( $relation ) ) {
						$load_relations = "{$key}.{$relation}";
					}
					$item->load( array( $load_relations ) );
				}
			}
		}
		return $this;
	}
}
