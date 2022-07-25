<?php

namespace Tokenly\Wp\Models\Token;

use Tokenly\Wp\Models\Post;
use Tokenly\Wp\Interfaces\Models\Token\MetaInterface;

use Tokenly\Wp\Models\Token\Asset;
use Tokenly\Wp\Interfaces\Models\Token\AssetInterface;
use Tokenly\Wp\Interfaces\Collections\Token\CategoryTermCollectionInterface;

class Meta extends Post implements MetaInterface {
	public ?AssetInterface $asset = null;
	public ?string $asset_name = null;
	public ?array $attributes = null;
	public ?array $media = null;
	public ?string $blockchain = null;
	public ?string $protocol = null;
	public ?string $image = null;

	/**
	 * @inheritDoc
	 */
	public function from_array( array $data = array() ): self {
		if ( isset( $data['asset'] ) && is_array( $data['asset'] ) ) {
			$data['asset'] = ( new Asset() )->from_array( $data['asset'] );
		}
		return parent::from_array( $data );
	}

	public function append_fallback(
		 string $taxonomy,
		 CategoryTermCollectionInterface $categories
	): self {
		$categories = clone $categories;
		$categories->key_by_field( 'term_id' );
		
		$terms = wp_get_post_terms( $this->ID, $taxonomy );
		foreach ( $terms as $term ) {
			$id = $term->term_id;
			if ( isset( $categories[ $id ] ) ) {
				$category = $categories[ $id ];
				if ( $category->image && !$this->image ) {
					$this->image = $category->image['url'];
				}
			}
		}
		return $this;
	}

	/**
	 * @inheritDoc
	 */
	public function to_array(): array {
		$array_parent = parent::to_array();
		$array = array(
			'asset_name'  => $this->asset_name,
			'attributes'  => $this->attributes,
			'media'       => $this->media,
			'blockchain'  => $this->blockchain,
			'protocol'    => $this->protocol,
			'slug'        => get_the_permalink( $this->ID ),
		);
		if ( $this->asset ) {
			$array['asset'] = $this->asset->to_array();
		}
		
		$array = array_merge( $array, $array_parent );
		return $array;
	}

	/**
	 * @inheritDoc
	 */
	protected function get_fillable(): array {
		return array_merge( parent::get_fillable(), array(
			'asset',
			'asset_name',
			'attributes',
			'media',
			'blockchain',
			'protocol',
		) );
	}
}
