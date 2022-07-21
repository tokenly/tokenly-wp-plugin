<?php

namespace Tokenly\Wp\Models\Token;

use Tokenly\Wp\Models\Term;
use Tokenly\Wp\Interfaces\Models\Token\CategoryTermInterface;

/**
 * WP_Term with some upgrades to support TCA
 */
class CategoryTerm extends Term implements CategoryTermInterface {
	public ?array $image = null;
	public ?array $media = null;

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
			'image' => $this->image,
			'media' => $this->media,
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
