<?php

namespace Tokenly\Wp\Repositories;

use Tokenly\Wp\Interfaces\Repositories\RepositoryInterface;

use Tokenly\Wp\Interfaces\Models\ModelInterface;
use Tokenly\Wp\Interfaces\Collections\CollectionInterface;

/**
 * Repository base class
 */
class Repository implements RepositoryInterface {
	/**
	 * @var array $memoized Memoized instances
	 */
	protected array $memoized = array();

	/**
	 * Formats the retrieved item to be suitable for factory
	 * @param array $item Item to format
	 * @return array $item Formatted item
	 */
	protected function format_item( array $item ): array {
		return $item;
	}

	/**
	 * Memoizes a new instance
	 * @param string $name Service method the new instance will be associated with.
	 * @param array $params Method parameters. They are used to key the instance.
	 * @param mixed $instance New instance data
	 * @return void
	 */
	protected function store_memoize( string $name, object $instance, array $arguments = array() ): void {
		$hash = $this->make_hash_memoize( $name, $arguments );
		$this->memoized[ $hash ] = $instance;
	}

	/**
	 * Retrieves a memoized instance
	 * @param string $name Service method
	 * @param array $params Method parameters. They are used to identify the instance.
	 * @return object|null
	 */
	protected function show_memoize( string $name, array $arguments ): ?object {
		$hash = $this->make_hash_memoize( $name, $arguments );
		if ( isset( $this->memoized[ $hash ] ) ) {
			return $this->memoized[ $hash ];
		} else {
			return null;
		}
	}

	/**
	 * Makes a hash to identify the memoized instance later,
	 * using the search parameters which were used to retrieve it
	 * @param string $name Service method
	 * @param array $arguments Method arguments
	 * @return string
	 */
	protected function make_hash_memoize( string $name, array $arguments ): string {
		$arguments = serialize( $arguments );
		$arguments = "{$name}_{$arguments}";
		$hash = md5( $arguments );
		return $hash;
	}

	/**
	 * Searches for a cached instance for the specified method, if none
	 * found calls the method.
	 * @param string $method Method name
	 * @param array $params Method arguments
	 * @return object|null
	 */
	protected function handle_method( string $method, array $arguments = array() ): ?object {
		$method_cacheable = "{$method}_cacheable";
		if ( !method_exists( $this, $method_cacheable ) ) {
			throw new \Exception( "Cacheable method not found!" );
		}
		$instance = $this->show_memoize( $method, $arguments );
		if ( $instance ) {
			return $instance;
		}
		$instance = $this->{$method_cacheable}( ...$arguments );
		if ( !$instance ) {
			return null;
		}
		if ( is_object( $instance ) && isset( $arguments[0] ) && isset( $arguments[0]['with'] ) ) {
			$params = $arguments[0];
			unset( $params['with'] );
			$this->load( $instance, $arguments[0]['with'], $params );
		}
		$this->store_memoize( $method, $instance, $arguments );
		return $instance;
	}

	/**
	 * Loads the specified relations
	 * @param string[] $relations List of relations to load
	 * @return object
	 */
	public function load( object $instance, array $relations = array(), array $params = array() ): object {
		foreach ( $relations as $key => $relation ) {
			if ( $instance instanceof ModelInterface ) {
				if ( !$relation ) {
					continue;
				}
				$relation_formatted = $this->format_relation( $relation );
				if ( !isset( $relation_formatted['root'] ) ) {
					continue;
				}
				$relation = $relation_formatted['root'];
				$relations_nested = $relation_formatted['relations'] ?? null;
				if ( $instance->{"get_{$relation}"}() && is_object( $instance->{"get_{$relation}"}() ) ) {
					$this->{"{$relation}_repository"}->load( $instance->{"get_{$relation}"}(), array( $relations_nested ), $params );
					continue;
				} else {
					if ( method_exists( $this, "load_{$relation}" ) && method_exists( $instance, "set_{$relation}" ) ) {
						$relation_instance = call_user_func( array( $this, "load_{$relation}" ), $instance, array( $relations_nested ), $params );
						$instance->{"set_{$relation}"}( $relation_instance );
					}
				}
			} elseif ( $instance instanceof CollectionInterface ) {
				foreach ( $instance as &$instance_item ) {
					$this->load( $instance_item, $relations, $params );
				}
			}
		}
		return $instance;
	}

	protected function format_relation( string $relation ): array {
		$has_nested = $this->str_contains( $relation, '.' );
		if ( !$has_nested ) {
			$root = $relation;
			$relations = null;
		} else {
			$relation = explode( '.', $relation );
			$root = $relation[0];
			unset( $relation[0] );
			$relations = implode( '.', $relation );
		}
		return array(
			'root'      => $root,
			'relations' => $relations,
		);
	}

	protected function str_contains( $haystack, $needle ): bool {
		return $needle !== '' && mb_strpos($haystack, $needle) !== false;
	}
}
