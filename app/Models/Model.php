<?php

namespace Tokenly\Wp\Models;

use Tokenly\Wp\Interfaces\Models\ModelInterface;
use Tokenly\Wp\Interfaces\Collections\CollectionInterface;
use Tokenly\Wp\Traits\RelatableTrait;

class Model implements ModelInterface {
	use RelatableTrait;

	protected $fillable = array();
	protected $domain_repository;

	public function __construct(
		array $data = array()
	) {
		$this->fill( $data );
	}

	/**
	 * Fills the class properties from an array
	 * @param array $data New data
	 * @return object
	 */
	public function fill( array $data = array() ) {
		foreach( $data as $key => $value ) {
			if ( !in_array( $key, $this->fillable ) ) {
				continue;
			} 
			$this->{$key} = $value;
		}
		return $this;
	}

	/**
	 * Returns public properties of the model as array
	 * @return array
	 */
	public function to_array() {
		$array = array();
		foreach( (array) $this as $key => $property ) {
			if ( !in_array( $key, $this->fillable ) ) {
				continue;
			} 
			if ( is_object( $property ) ) {
				if ( $property instanceof ModelInterface || $property instanceof CollectionInterface ) {
					$array[ $key ] = $property->to_array();
					continue;
				} else {
					continue;
				}
			}
			$array[ $key ] = $property;
		}
		return $array;
	}

	/**
	 * Updates the model
	 * @param array $data New data
	 * @return object
	 */
	public function update( array $data = array() ) {
		$this->fill( $data );
		return $this->save();
	}

	/**
	 * Saves the model
	 * @return object
	 */
	public function save() {
		$save_data = $this->to_array();
		foreach ( $save_data as $key => $save_data_item ) {
			if ( !in_array( $key, $this->fillable ) ) {
				unset( $save_data[ $key ] );
			}
		}
		return $this->domain_repository->update( $this, $save_data );
	}

	/**
	 * Loads the specified relations
	 * @param string[] $relations List of relations to load
	 * @return self
	 */
	public function load( array $relations = array() ) {
		$relations = $this->format_relations( $relations );
		foreach ( $relations as $key => $relation ) {
			$load_relations = array();
			if ( !empty( $relation ) ) {
				$load_relations = array( $relation );
			}
			if ( isset( $this->{$key} ) && is_object( $this->{$key} ) ) {
				$this->{$key}->load( $load_relations );
				continue;
			}
			call_user_func( array( $this, "load_{$key}" ), $load_relations );
		}
		return $this;
	}
}
