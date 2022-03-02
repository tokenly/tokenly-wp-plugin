<?php

namespace Tokenly\Wp\Models\Token;

use Tokenly\Wp\Models\Term;
use Tokenly\Wp\Interfaces\Models\Token\CategoryTermInterface;

/**
 * WP_Term with some upgrades to support TCA
 */
class CategoryTerm extends Term implements CategoryTermInterface {
	protected ?array $image = null;
	protected ?array $media = null;

	public function get_image(): ?array {
		return $this->image ?? null;
	}

	public function set_image( ?array $value ): void {
		$this->image = $value;
	}

	public function get_media(): ?array {
		$value = $this->media ?? null;
		if ( is_array( $value ) ) {
			$value = array_filter( $value );
		}
		return $value;
	}

	public function set_media( ?array $value ): void {
		if ( is_array( $value ) ) {
			$value = array_filter( $value );
		}
		$this->media = $value;
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
		$array_parent = parent::to_array();
		$array = array(
			'image' => $this->get_image(),
			'media' => $this->get_media(),
		);
		$array = array_merge( $array, $array_parent );
		return $array;
	}

	/**
	 * @inheritDoc
	 */
	protected function get_fillable(): array {
		return array_merge( parent::get_fillable(), array(
			'image',
			'media',
		) );
	}
}
