<?php

namespace Tokenly\Wp\Models;

use Tokenly\Wp\Interfaces\Models\ModelInterface;

class Model implements ModelInterface {
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

	/**
	 * Returns public properties of the model as array
	 * @return array
	 */
	public function to_array() {
		$reflection = new \ReflectionClass( $this );
		$public = $reflection->getProperties( \ReflectionProperty::IS_PUBLIC );
		foreach( $public as $key => &$property ) {
			if ( !in_array( $key, $this->fillable ) ) {
				unset( $public[ $key ] );
			} 
			if ( !is_object( $property ) ) {
				continue;
			}
			$property = $property->to_array();
		}
		return $public;
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
		return $this->domain_repository->update( $this, $save_data );
	}
}
