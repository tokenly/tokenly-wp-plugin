<?php

namespace Tokenly\Wp\Models\Token;

use Tokenly\Wp\Models\Post;
use Tokenly\Wp\Interfaces\Models\Token\MetaInterface;

use Tokenly\Wp\Models\Token\Asset;
use Tokenly\Wp\Interfaces\Models\Token\AssetInterface;
use Tokenly\Wp\Interfaces\Collections\Token\CategoryTermCollectionInterface;

class Meta extends Post implements MetaInterface {
	protected ?AssetInterface $asset = null;
	protected ?string $asset_name = null;
	protected ?array $attributes = null;
	protected ?array $media = null;
	protected ?string $blockchain = null;
	protected ?string $protocol = null;
	protected ?string $image = null;

	public function get_asset(): ?AssetInterface {
		return $this->asset ?? null;
	}

	public function set_asset( ?AssetInterface $value ): void {
		$this->asset = $value;
		$this->set_asset_name( $this->get_asset()->get_name() );
	}

	public function get_asset_name(): ?string {
		return $this->asset_name ?? null;
	}

	public function set_asset_name( ?string $value ): void {
		$this->asset_name = $value;
	}

	public function get_attributes(): ?array {
		return $this->attributes ?? null;
	}

	public function set_attributes( ?array $value ): void {
		$this->attributes = $value;
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
	
	public function get_blockchain(): ?string {
		return $this->blockchain ?? null;
	}

	public function set_blockchain( ?string $value ): void {
		$this->blockchain = $value;
	}

	public function get_protocol(): ?string {
		return $this->protocol ?? null;
	}

	public function set_protocol( ?string $value ): void {
		$this->protocol = $value;
	}

	public function get_image(): ?string {
		return $this->image ?? parent::get_image();
	}

	public function set_image( ?string $value ): void {
		$this->image = $value;
	}

	/**
	 * @inheritDoc
	 */
	public function from_array( array $data = array() ): self {
		if ( isset( $data['asset'] ) && is_array( $data['asset'] ) ) {
			$data['asset'] = ( new Asset() )->from_array( $data['asset'] );
		}
		return parent::from_array( $data );
	}

	public function append_fallback( string $taxonomy, CategoryTermCollectionInterface $categories ): self {
		$categories = clone $categories;
		$categories->key_by_field( 'term_id' );
		
		$terms = wp_get_post_terms( $this->ID, $taxonomy );
		foreach ( $terms as $term ) {
			$id = $term->term_id;
			if ( isset( $categories[ $id ] ) ) {
				$category = $categories[ $id ];
				if ( $category->get_image() && !$this->get_image() ) {
					$this->set_image( $category->get_image()['url'] );
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
			'asset_name'  => $this->get_asset_name(),
			'attributes'  => $this->get_attributes(),
			'media'       => $this->get_media(),
			'blockchain'  => $this->get_blockchain(),
			'protocol'    => $this->get_protocol(),
			'slug'        => get_the_permalink( $this->ID ),
		);
		if ( $this->get_asset() ) {
			$array['asset'] = $this->get_asset()->to_array();
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
