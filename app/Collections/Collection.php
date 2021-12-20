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

	/**
	 * Fills the collection with data
	 * @param array $items Items to add
	 * @return self
	 */
	public function fill( array $items ) {
		foreach ( $items as $item )
		{
			if ($item instanceof $this->item_type === FALSE ) {
				throw new \Exception("Cannot append non " . $this->item_type . " to collection");
			}
		}
		$this->exchangeArray( $items );
		return $this;
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

	/**
	 * Keys the collection by its field
	 * @param string $field Field name
	 * @return self
	 */
	public function key_by_field( string $field ) {
		$keyed = array();
		foreach ( ( array ) $this as $item ) {
			$keyed[ $item->$field ] = $item;
		}
		$this->exchangeArray( $keyed );
		return $this;
	}

	/**
	 * Merges the specified collection
	 * @param ColectionInterface $collection Collection to merge
	 * @return self
	 */
	public function merge( CollectionInterface $collection ) {
		foreach ( ( array ) $collection as $item ) {
			if ( $item instanceof $this->item_type === true ) {
				$this[] = $item;
			}
		}
		return $this;
	}

	/**
	 * Loads the specified relations.
	 * @param string[] $relations Relations to load
	 * @return self
	 */
	public function load( array $relations = array() ) {
		foreach ( $relations as $key => $relation ) {
			if ( !$relation ) {
				continue;
			}
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
