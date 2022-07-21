<?php

namespace Tokenly\Wp\Models\Settings;

use Tokenly\Wp\Models\Settings;
use Tokenly\Wp\Interfaces\Models\Settings\TcaSettingsInterface;

class TcaSettings extends Settings implements TcaSettingsInterface {
	public ?array $post_types = array();
	public ?array $taxonomies = array();
	public ?bool $filter_menu_items = true;
	public ?bool $filter_post_results = true;

	public function __get( $name ) {
		switch ( $name ) {
			case 'available_post_types':
				$this->get_available_post_types();
				break;
			case 'available_taxonomies':
				$this->get_available_taxonomies();
				break;
		}
    }
	
	/**
	 * @inheritDoc
	 */
	public function from_array( array $data = array() ): self {
		return parent::from_array( $data );
	}

	/**
	 * @inheritDoc
	 */
	public function to_array(): array {
		$array = array(
			'taxonomies'          => $this->taxonomies,
			'post_types'          => $this->post_types,
			'filter_menu_items'   => $this->filter_menu_items,
			'filter_post_results' => $this->filter_post_results,
		);
		return $array;
	}

	/**
	 * Checks whether the specified post type has TCA enabled
	 * @param string $post_type Post type to check
	 * @return bool
	 */
	public function is_enabled_for_post_type( string $post_type ): bool {
		return $this->get_post_types()[ $post_type ] ?? false;
	}

	/**
	 * Checks whether the specified taxonomy has TCA enabled
	 * @param string $taxonomy Taxonomy to check
	 * @return bool
	 */
	public function is_enabled_for_taxonomy( string $taxonomy ): bool {
		return $this->get_taxonomies()[ $taxonomy ] ?? false;
	}

	/**
	 * Returns an array of post types for which TCA can be enabled
	 * @return array
	 */
	protected function get_available_post_types(): array {
		$post_type_objects = get_post_types( array(), 'objects' );
		$post_types = array();
		foreach ( $post_type_objects as $post_type_object ) {
			$post_types[ $post_type_object->name ] = $post_type_object->label; 
		}
		return $post_types;
	}

	/**
	 * Returns an array of taxonomies for which TCA can be enabled
	 * @return array
	 */
	protected function get_available_taxonomies(): array {
		$taxonomy_objects = get_taxonomies( array(), 'object_type' );
		$taxonomies = array();
		foreach ( $taxonomy_objects as $taxonomy_object ) {
			$taxonomies[ $taxonomy_object->name ] = $taxonomy_object->label; 
		}
		return $taxonomies;
	}

	/**
	 * Gets a collection of post types for which TCA is enabled
	 * @return array
	 */
	public function get_enabled_post_types(): array {
		$post_types_enabled = array();
		foreach ( $this->get_post_types() as $key => $post_type ) {
			if ( $post_type == true ) {
				$post_types_enabled[] = $key;
			}
		}
		return $post_types_enabled;
	}

	/**
	 * Gets a collection of taxonomies for which TCA is enabled
	 * @return array
	 */
	public function get_enabled_taxonomies(): array {
		$taxonomies_enabled = array();
		foreach ( $this->get_taxonomies() as $key => $taxonomy ) {
			if ( $taxonomy == true ) {
				$taxonomies_enabled[] = $key;
			}
		}
		return $taxonomies_enabled;
	}

	/**
	 * @inheritDoc
	 */
	protected function get_fillable(): array {
		return array_merge( parent::get_fillable(), array(
			'taxonomies',
			'post_types',
			'filter_menu_items',
			'filter_post_results',
		) );
	}
}
