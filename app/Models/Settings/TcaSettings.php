<?php

namespace Tokenly\Wp\Models\Settings;

use Tokenly\Wp\Models\Settings;
use Tokenly\Wp\Interfaces\Models\Settings\TcaSettingsInterface;

class TcaSettings extends Settings implements TcaSettingsInterface {
	public $post_types = array();
	public $taxonomies = array();
	public $filter_menu_items = true;
	public $filter_post_results = true;
	protected $option_prefix = 'tca';
	protected $fillable = array(
		'taxonomies',
		'post_types',
		'filter_menu_items',
		'filter_post_results',
	);

	/**
	 * Checks whether the specified post type has TCA enabled
	 * @param string $post_type Post type to check
	 * @return bool
	 */
	public function is_enabled_for_post_type( string $post_type ) {
		return $this->post_types[ $post_type ] ?? false;
	}

	/**
	 * Checks whether the specified taxonomy has TCA enabled
	 * @param string $taxonomy Taxonomy to check
	 * @return bool
	 */
	public function is_enabled_for_taxonomy( string $taxonomy ) {
		return $this->taxonomies[ $taxonomy ] ?? false;
	}

	/**
	 * Returns an array of post types for which TCA can be enabled
	 * @return array
	 */
	public function get_available_post_types() {
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
	public function get_available_taxonomies() {
		$taxonomy_objects = get_taxonomies( array(), 'object_type' );
		$taxonomies = array();
		foreach ( $taxonomy_objects as $taxonomy_object ) {
			$taxonomies[ $taxonomy_object->name ] = $taxonomy_object->label; 
		}
		return $taxonomies;
	}
}
