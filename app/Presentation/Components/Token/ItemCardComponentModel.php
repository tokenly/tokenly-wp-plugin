<?php

namespace Tokenly\Wp\Presentation\Components\Token;

use Tokenly\Wp\Presentation\Components\ComponentModel;
use Tokenly\Wp\Interfaces\Presentation\Components\Token\ItemCardComponentModelInterface;
use Tokenly\Wp\Interfaces\Repositories\General\PostMetaRepositoryInterface;

class ItemCardComponentModel extends ComponentModel 
	implements ItemCardComponentModelInterface
{	
	protected PostMetaRepositoryInterface $meta_repository;
	protected string $fallback_image;

	public function __construct(
		string $fallback_image,
		PostMetaRepositoryInterface $meta_repository
	) {
		$this->fallback_image = $image;
		$this->meta_repository = $meta_repository;
	}

	/**
	 * @inheritDoc
	 */
	public function prepare( array $data = array() ): ?array {
		if ( !isset( $data['balance'] ) ) {
			return null;
		}
		$balance = $data['balance'];
		$name = $balance->name;
		$asset = $balance->asset;
		$asset = $asset->name;
		$amount = $balance->quantity->value;
		$description = 'No description.';
		$image = '';
		$extra = array();
		if ( $balance->meta ) {
			$meta = $balance->meta;
			$post_id = $meta->ID;
			$name = $meta->post_title;
			$image = get_the_post_thumbnail( $post_id, 'full' );
			if ( !$image ) {
				$image = "<img src='{$fallback_image}'>";
			}
			$excerpt = get_the_excerpt( $post_id );
			if ( !empty( $description ) ) {
				$description = $excerpt;
			}
			if ( $meta->asset ) {
				$asset = $meta->asset;
				$asset = $asset->name;
			}
		}
		$data = array(
			'asset'       => $asset,
			'name'        => $name,
			'description' => $description,
			'image'       => $image,
			'balance'     => $amount,
		);
		return $data;
	}
}
