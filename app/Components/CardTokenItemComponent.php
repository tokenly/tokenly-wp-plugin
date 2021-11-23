<?php

namespace Tokenly\Wp\Components;

use Tokenly\Wp\Components\Component;
use Twig\Environment;
use Tokenly\Wp\Interfaces\Repositories\General\MetaRepositoryInterface;
use Tokenly\Wp\Interfaces\Components\CardTokenItemComponentInterface;

class CardTokenItemComponent extends Component implements CardTokenItemComponentInterface {	
	protected $meta_repository;
	
	public function __construct(
		Environment $twig,
		MetaRepositoryInterface $meta_repository
	) {
		parent::__construct( $twig );
		$this->meta_repository = $meta_repository;
	}

	public function render( $data ) {
		if ( !isset( $data['balance'] ) ) {
			return;
		}
		$balance = $data['balance'];
		$name = $balance->name;
		$asset = $balance->asset;
		$amount = $balance->balance;
		$description = 'No description.';
		$image = '';
		$extra = array();
		if ( isset( $balance->meta ) ) {
			$post_id = $balance->meta->ID;
			$name = get_the_title( $post_id );
			$image = get_the_post_thumbnail( $post_id, 'full' );
			$excerpt = get_the_excerpt( $post_id );
			if ( !empty( $description ) ) {
				$description = $excerpt;
			}
			$additional_meta = $this->meta_repository->index( $post_id, array(
				'asset',
				'extra',
			) );
			if ( isset( $additional_meta['asset'] ) ) {
				$asset = $additional_meta['asset'];
			}
			if ( isset( $additional_meta['extra'] ) ) {
				$extra = $additional_meta['extra'];
			}
		}
		$html = $this->twig->render( 'components/CardTokenItemComponent.twig', array(
			'asset'       => $asset,
			'name'        => $name,
			'description' => $description,
			'image'       => $image,
			'balance'     => $amount,
			'extra'       => $extra,
		) );
		return $html;
	}
}
