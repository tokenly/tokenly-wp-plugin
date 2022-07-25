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

	public ?TermCollectionInterface $term = null;
	public ?\WP_Post $post = null;

	public function __call( $method, $args ) {
		return call_user_func_array( array( $this->post, $method ), $args );
	}

	public function __get( $key ) {
		return $this->post->$key;
	}

	public function __set( $key, $value ) {
		return $this->post->$key = $value;
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
			'id'          => $this->post->ID,
			'name'        => $this->post->post_title,
			'description' => $this->post->post_excerpt,
			'image'       =>
				wp_get_attachment_url(
					get_post_thumbnail_id( $this->ID ), 'full'
				),
		);
		if ( $this->term ) {
			$array['term'] = $this->term->to_array();
		}
		$array_protectable = $this->protectable_to_array();
		$array = array_merge( $array, $array_protectable );
		return $array;
	}

	public function get_tca_rules_relation() {
		$rules = null;
		if ( $this->term ) {
			$rules = $this->term->tca_rules;
		}
		return $rules;
	}

	/**
	 * @inheritDoc
	 */
	protected function get_fillable(): array {
		return array_merge(
			parent::get_fillable(),
			$this->protectable_get_fillable(),
			array(
				'post',
			)
		);
	}
}
