<?php

namespace Tokenly\Wp\Models;

use Tokenly\Wp\Models\Model;
use Tokenly\Wp\Interfaces\Models\TermInterface;
use Tokenly\Wp\Interfaces\Traits\ProtectableInterface;
use Tokenly\Wp\Traits\ProtectableTrait;

/**
 * WP_Term with some upgrades to support TCA
 */
class Term extends Model implements TermInterface, ProtectableInterface {
	use ProtectableTrait;

	protected ?\WP_Term $term = null;

	public function __call( $method, $args ) {
		return call_user_func_array( array( $this->term, $method ), $args );
	}

	public function __get( $key ) {
		return $this->term->$key;
	}

	public function __set( $key, $value ) {
		return $this->term->$key = $value;
	}

	public function get_term(): ?\WP_Term {
		return $this->term ?? null;
	}

	public function set_term( ?\WP_Term $value ): void {
		$this->term = $value;
	}

	/**
	 * @inheritDoc
	 */
	public function from_array( array $data = array() ): self {
		$data = $this->protectable_from_array( $data );
		return parent::from_array( $data );
	}

	/**
	 * @inheritDoc
	 */
	public function to_array(): array {
		$term = $this->get_term();
		$array = array(
			'id'          => $term->slug,
			'name'        => $term->name,
			'description' => $term->description,
			'slug'        => $term->slug,
			'link'        => get_term_link( $term, $term->taxonomy )
		);
		$array_protectable = $this->protectable_to_array();
		$array = array_merge( $array, $array_protectable );
		return $array;
	}

	/**
	 * @inheritDoc
	 */
	protected function get_fillable(): array {
		return array_merge( parent::get_fillable(), $this->protectable_get_fillable(), array(
			'term',
		) );
	}

	public function get_tca_rules_relation() {
		return null;
	}
}
