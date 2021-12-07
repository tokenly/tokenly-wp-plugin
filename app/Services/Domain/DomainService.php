<?php

namespace Tokenly\Wp\Services\Domain;

use Tokenly\Wp\Interfaces\Services\Domain\DomainServiceInterface;
use Tokenly\Wp\Interfaces\Collections\CollectionInterface;
use Tokenly\Wp\Services\Service;

/**
 * Provides the base functions for the other domain services.
 * 
 * The domain services provide ways to access and manage data for the rest of the application.
 * 
 * Provides a memoization mechanism for methods marked with _ since some of them make external
 * requests which are expensive.
 */
class DomainService extends Service implements DomainServiceInterface {
	/**
	 * @var array $memoized Memoized instances
	 */
	protected $memoized = array();

	/**
	 * Memoizes a new instance
	 * @param string $name Service method the new instance will be associated with.
	 * @param array $params Method parameters. They are used to key the instance.
	 * @param mixed $instance New instance data
	 * @return void
	 */
	protected function store_memoize( string $name, array $params = array(), object $instance ) {
		$hash = $this->make_hash_memoize( $name, $params );
		$this->memoized[ $hash ] = $instance;
	}

	/**
	 * Retrieves a memoized instance
	 * @param string $name Service method
	 * @param array $params Method parameters. They are used to identify the instance.
	 * @return object
	 */
	protected function show_memoize( string $name, array $arguments = array() ) {
		$hash = $this->make_hash_memoize( $name, $arguments );
		if ( isset( $this->memoized[ $hash ] ) ) {
			return $this->memoized[ $hash ];
		} else {
			return false;
		}
	}

	/**
	 * Makes a hash to identify the memoized instance later,
	 * using the search parameters which were used to retrieve it
	 * @param string $name Service method
	 * @param array $arguments Method arguments
	 * @return string
	 */
	protected function make_hash_memoize( string $name, array $arguments = array() ) {
		$arguments = serialize( $arguments );
		$arguments = "{$name}_{$arguments}";
		$hash = md5( $arguments );
		return $hash;
	}

	/**
	 * Checks if the called method has an underscore version
	 * if it does attempts to retrieve a memoized instance and load relations
	 * @param string $name Method name
	 * @param array $params Method arguments
	 * @return object
	 */
	public function __call( string $name, array $arguments ) {
		if ( !method_exists( $this, "_{$name}" ) ) {
			return false;
		}
		$instance = $this->show_memoize( $name, $arguments );
		if ( $instance ) {
			return $instance;
		}
		$instance = $this->{"_{$name}"}( ...$arguments );
		if ( !$instance ) {
			return false;
		}
		if ( is_object( $instance ) && isset( $arguments[0] ) && isset( $arguments[0]['with'] ) ) {
			$instance->load( $arguments[0]['with'] );
		}
		$this->store_memoize( $name, $arguments, $instance );
		return $instance;
	}
}
