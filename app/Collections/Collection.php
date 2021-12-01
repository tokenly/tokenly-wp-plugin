<?php

/**
 * Collection base class
 */

namespace Tokenly\Wp\Collections;

use Tokenly\Wp\Interfaces\Collections\CollectionInterface;

class Collection extends \ArrayObject implements CollectionInterface {
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

	public function load() {
		
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
}
