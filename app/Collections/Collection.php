<?php

/**
 * Collection base class
 */

namespace Tokenly\Wp\Collections;

use Tokenly\Wp\Interfaces\Collections\CollectionInterface;

use Tokenly\Wp\Models\Model;

class Collection extends \ArrayObject implements CollectionInterface {
	protected string $item_type = Model::class;
	protected object $domain_service;
	protected bool $keyed = false;

	public function __construct( array $items = array() ) {
		$this->fill( $items );
	}

	/**
	 * Fills the collection with data
	 * @param array $items Items to add
	 * @return self
	 */
	public function fill( array $items = array() ): self {
		foreach ( $items as $item )
		{
			if ( !$item ) {
				continue;
			}
			if ( $item instanceof $this->item_type === FALSE ) {
				continue;
			}
		}
		$this->exchangeArray( $items );
		return $this;
	}

	public function from_array( array $data = array() ): self {
		foreach ( $data as &$item ) {
			$item = ( new $this->item_type() )->from_array( $item );
		}
		$this->fill( $data );
		return $this;
	}

	/**
	 * Converts the collection to array
	 * @return array
	 */
	public function to_array(): array {
		$array = array();
		foreach ( ( array ) $this as $key => $item ) {
			$item_array = $item->to_array();
			if ( $this->keyed === true ) {
				$array[ $key ] = $item_array;
			} else {
				$array[] = $item_array;
			}
		}
		return $array;
	}

	/**
	 * Keys the collection by its field
	 * @param string $field Field name
	 * @return self
	 */
	public function key_by_field( string $field ): self {
		$this->keyed = true;
		$keyed = array();
		foreach ( ( array ) $this as $item ) {
			$keyed[ $item->{"get_{$field}"}() ] = $item;
		}
		$this->exchangeArray( $keyed );
		return $this;
	}

	/**
	 * Merges the specified collection
	 * @param ColectionInterface $collection Collection to merge
	 * @return self
	 */
	public function merge( CollectionInterface $collection ): self {
		foreach ( ( array ) $collection as $item ) {
			if ( $item instanceof $this->item_type === true ) {
				$this[] = $item;
			}
		}
		return $this;
	}

	public function extract( string $field ): array {
		$extracted = array();
		foreach ( ( array ) $this as $key => $item ) {
			if ( !$item ) {
				continue;
			}
			$value = $item->{"get_{$field}"}();
			if ( $this->keyed === true ) {
				$extracted[ $key ] = $value;
			} else {
				$extracted[] = $value;
			}
		}
		return $extracted;
	}

	/**
	 * Groups the collection items by a field and its value
	 * @param string $field Field to group by
	 * @return array
	 */
	public function group_by_field( string $field ): array {
		$grouped = array();
		foreach ( ( array ) $this as $key => $item ) {
			if ( isset( $item[ $field ] ) ) {
				$value = $item[ $field ];
				if ( is_array( $value ) ) {
					foreach ( $value as $value_item ) {
						if ( !array_key_exists( $value_item, $grouped ) ) {
							$grouped[ $value_item ] = array();
						}
						$grouped[ $value_item ][ $key ] = $item;
					}
				} else {
					if ( !array_key_exists( $value, $grouped ) ) {
						$grouped[ $value ] = new self( array() );
					}
					$grouped[ $value ][ $key ] = $item;
				}
			}
		}
		return $grouped;
	}
}
