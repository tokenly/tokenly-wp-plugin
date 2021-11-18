<?php

namespace Tokenly\Wp\Components;

use Tokenly\Wp\Components\Component;
use Twig\Environment;
use Tokenly\Wp\Interfaces\Repositories\General\MetaRepositoryInterface;

class CardTokenItemComponent extends Component {	
	public function __construct(
		Environment $twig,
		MetaRepositoryInterface $meta_repository
	) {
		parent::__construct( $twig );
		$this->meta_repository = $meta_repository;
	}

	public function render( $data ) {
		$balance = $data['balance'] ?? null;
		$meta = $balance->meta ?? null;
		$name = $balance->name;
		$asset = $balance->asset;
		$balance = $balance->balance;
		$description = '';
		$extra = '';
		$image = '';
		if ( $meta ) {
			$post_id = $meta->ID;
			$name = get_the_title( $post_id );
			$image = get_the_post_thumbnail( $post_id, 'full' );
			$description = get_the_excerpt( $post_id );
			$additional_meta = $this->meta_repository->index( $post_id, array(
				'asset',
			) );
			$asset = $additional_meta['asset'] ?? null;
			if ( $asset ) {
				$meta_item['asset'] = $asset;
				if ( $balances_keyed[ $asset ] ?? null ) {
					$balances_keyed[ $asset ]->meta = $meta_item;
				}
			}
		} 
		$html = $this->twig->render( 'components/CardTokenItemComponent.twig', array(
			'asset'       => $asset,
			'name'        => $name,
			'description' => $description,
			'image'       => $image,
			'balance'     => $balance,
			// 'extra'       => $extra,
		) );
		return $html;
	}
}
