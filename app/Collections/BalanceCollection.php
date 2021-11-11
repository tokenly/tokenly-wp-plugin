<?php

/**
 * Collection of Balance objects
 */

namespace Tokenly\Wp\Collections;

use Tokenly\Wp\Interfaces\Repositories\General\MetaRepositoryInterface;
use Tokenly\Wp\Interfaces\Repositories\Post\TokenMetaRepositoryInterface;
use Tokenly\Wp\Interfaces\Collections\BalanceCollectionInterface;
use Tokenly\Wp\Interfaces\Models\WhitelistInterface;

class BalanceCollection extends \ArrayObject implements BalanceCollectionInterface {
	public function __construct(
		MetaRepositoryInterface $meta_repository,
		TokenMetaRepositoryInterface $token_meta_repository,
		WhitelistInterface $whitelist
	) {
		$this->token_meta_repository = $token_meta_repository;
		$this->meta_repository = $meta_repository;
		$this->whitelist = $whitelist;
	}

	/**
	 * Applies the whitelist to the balances
	 * @param array $balances Token balances
	 * @return array
	 */
	public function apply_whitelist( $balances ) {
		if ( $this->whitelist->enabled == true ) {
			$items = $this->whitelist->items ?? null;
			$balances_filtered = array();
			if ( $items ) {
				foreach ( $items as $item ) {
					$whitelist_rule = implode( ':', array_filter( array( $item->address, $item->index ) ) );
					$search = array_search( $whitelist_rule, array_column( $balances, 'asset' ) );
					if ( $search !== false ) {
						$balances_filtered[] = $balances[ $search ];
					}
				}
			}
			return $balances_filtered;
		}
		return $balances;
	}

	/**
	 * Embeds the WordPress token meta post data into the balance objects
	 * to provide additional information about the tokens
	 * @param array $balances Token balances
	 * @return array
	 */
	public function embed_token_meta( $balances ) {
		$assets = array_map( function( $balance ) {
			return $balance->name;
		}, $balances );
		$query_meta = $this->token_meta_repository->index( array(
			'assets' => $assets,
		) );
		$balances_keyed = array();
		foreach( $balances as $balance ) {
			$balances_keyed[ $balance->name ] = $balance;
		}
		$meta = array();
		while ( $query_meta->have_posts() ) {
			$query_meta->the_post();
			$post_id = get_the_ID();
			$meta_item = array();
			$meta_item['name'] = get_the_title();
			$meta_item['image'] = get_the_post_thumbnail( $post_id, 'full' );
			$meta_item['description'] = get_the_excerpt();
			$additional_meta = $this->meta_repository->index( $post_id, array(
				'asset',
				'extra',
			) );
			$asset = $additional_meta['asset'] ?? null;
			$extra = $additional_meta['extra'] ?? null;
			if ( $asset ) {
				$meta_item['asset'] = $asset;
				if ( $extra ) {
					$meta_item['extra'] = $extra;
				}
				if ( $balances_keyed[ $asset ] ?? null ) {
					$balances_keyed[ $asset ]->meta = $meta_item;
				}
			}
		}
		return $balances_keyed;
	}
}