<?php

namespace Tokenly\Wp\Models;

use Tokenly\Wp\Interfaces\Models\ModelInterface;

class Model implements ModelInterface {
	protected $fillable = array();
	protected $domain_service;

	public function __construct(
		array $data = array()
	) {
		$this->fill( $data );
	}

	/**
	 * Loads the specified relation
	 * @param string $relation
	 * @return object
	 */
	public function load( string $relation ) {
		return $this->domain_service->load( $this, $relation );
	}

	/**
	 * Fills the class properties from an array
	 * @param array $data New data
	 * @return object
	 */
	public function fill( array $data ) {
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
	public function update( array $data ) {
		$this->fill( $data );
		return $this->save();
	}

	/**
	 * Saves the model
	 * @return object
	 */
	public function save() {
		$save_data = $this->to_array();
		return $this->domain_service->update( $save_data );
	}
}
