<?php

namespace Tokenly\Wp\Presentation\Components;

use Tokenly\Wp\Presentation\Components\ComponentModel;
use Tokenly\Wp\Interfaces\Presentation\Components\TokenItemCardComponentModelInterface;
use Tokenly\Wp\Interfaces\Repositories\General\PostMetaRepositoryInterface;

class TokenItemCardComponentModel extends ComponentModel implements TokenItemCardComponentModelInterface {	
	protected $meta_repository;
	
	public function __construct(
		PostMetaRepositoryInterface $meta_repository
	) {
		$this->meta_repository = $meta_repository;
	}

	public function prepare( array $data = array() ) {
		if ( !isset( $data['balance'] ) ) {
			return;
		}
		$balance = $data['balance'];
		$name = $balance->name;
		$asset = $balance->asset;
		$amount = $balance->quantity->get_value();
		$description = 'No description.';
		$image = '';
		$extra = array();
		if ( isset( $balance->token_meta ) ) {
			$meta = $balance->token_meta;
			$post_id = $meta->ID;
			$name = $meta->post_title;
			$image = get_the_post_thumbnail( $post_id, 'full' );
			$excerpt = get_the_excerpt( $post_id );
			if ( !empty( $description ) ) {
				$description = $excerpt;
			}
			if ( isset( $meta->asset ) ) {
				$asset = $meta->asset;
			}
			if ( isset( $meta->extra ) ) {
				$extra = $meta->extra;
			}
		}
		return array(
			'asset'       => $asset,
			'name'        => $name,
			'description' => $description,
			'image'       => $image,
			'balance'     => $amount,
			'extra'       => $extra,
		);
	}
}
