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
		foreach ( $relations as $key => $relation ) {
			$relation_formatted = $this->format_relation( $relation );
			$method = "load_{$relation_formatted['root']}";
			if ( method_exists( $this, $method ) ) {
				call_user_func( array( $this, $method ), array( $relation_formatted['relations'] ) );
			} else {
				foreach ( (array) $this as $item ) {
					$item->load( array( $relation ) );
				}
			}
		}
		return $this;
	}
}
