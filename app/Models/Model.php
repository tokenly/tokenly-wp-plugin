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
	 * Deletes the model
	 * @return object
	 */
	public function destroy() {
		return $this->domain_repository->destroy( $this );
	}

	/**
	 * Loads the specified relations
	 * @param string[] $relations List of relations to load
	 * @return self
	 */
	public function load( array $relations = array() ) {
		foreach ( $relations as $key => $relation ) {
			if ( !$relation ) {
				continue;
			}
			$relation_formatted = $this->format_relation( $relation );
			if ( !isset( $relation_formatted['root'] ) ) {
				continue;
			}
			$relation = $relation_formatted['root'];
			$relations_nested = $relation_formatted['relations'] ?? null;
			if ( isset( $this->{$relation} ) && is_object( $this->{$relation} ) ) {
				$this->{$relation}->load( array( $relations_nested ) );
				continue;
			} else {
				$method = "load_{$relation}";
				if ( method_exists( $this, $method ) ) {
					$this->{$relation} = call_user_func( array( $this, $method ), array( $relations_nested ) );
				}
			}
		}
		return $this;
	}
}
