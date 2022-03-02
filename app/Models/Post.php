<?php

namespace Tokenly\Wp\Models;

use Tokenly\Wp\Models\Model;
use Tokenly\Wp\Interfaces\Models\PostInterface;
use Tokenly\Wp\Interfaces\Traits\ProtectableInterface;
use Tokenly\Wp\Traits\ProtectableTrait;

use Tokenly\Wp\Interfaces\Collections\TermCollectionInterface;

/**
 * WP_Post decorator
 */
class Post extends Model implements PostInterface, ProtectableInterface {
	use ProtectableTrait;

	protected ?TermCollectionInterface $term = null;
	protected ?\WP_Post $post = null;

	public function __call( $method, $args ) {
		return call_user_func_array( array( $this->get_post(), $method ), $args );
	}

	public function __get( $key ) {
		return $this->get_post()->$key;
	}

	public function __set( $key, $value ) {
		return $this->get_post()->$key = $value;
	}

	public function get_term(): ?TermCollectionInterface {
		return $this->term ?? null;
	}

	public function set_term( ?TermCollectionInterface $value ): void {
		$this->term = $value;
	}

	public function get_post(): ?\WP_Post {
		return $this->post ?? null;
	}

	public function set_post( ?\WP_Post $value ): void {
		$this->post = $value;
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
		$array = array(
			'id'          => $this->get_post()->ID,
			'name'        => $this->get_post()->post_title,
			'description' => $this->get_post()->post_excerpt,
			'image'       => wp_get_attachment_url( get_post_thumbnail_id( $this->get_post()->ID ), 'full' ),
		);
		if ( $this->get_term() ) {
			$array['term'] = $this->get_term()->to_array();
		}
		$array_protectable = $this->protectable_to_array();
		$array = array_merge( $array, $array_protectable );
		return $array;
	}

	public function get_tca_rules_relation() {
		$rules = null;
		if ( $this->get_term() ) {
			$rules = $this->get_term()->get_tca_rules();
		}
		return $rules;
	}

	/**
	 * @inheritDoc
	 */
	protected function get_fillable(): array {
		return array_merge( parent::get_fillable(), $this->protectable_get_fillable(), array(
			'post',
		) );
	}
}
