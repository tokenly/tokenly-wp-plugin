<?php

/**
 * Collection of Balance objects
 */

namespace Tokenly\Wp\Collections;

use Tokenly\Wp\Interfaces\Repositories\General\MetaRepositoryInterface;
use Tokenly\Wp\Interfaces\Repositories\Post\TokenMetaRepositoryInterface;
use Tokenly\Wp\Interfaces\Collections\BalanceCollectionInterface;
use Tokenly\Wp\Interfaces\Models\BalanceInterface;
use Tokenly\Wp\Interfaces\Models\WhitelistInterface;
use Tokenly\Wp\Interfaces\Factories\Models\BalanceFactoryInterface;
use Tokenly\Wp\Collections\Collection;

class BalanceCollection extends Collection implements BalanceCollectionInterface {
	protected $item_type = BalanceInterface::class;

	public function __construct(
		MetaRepositoryInterface $meta_repository,
		TokenMetaRepositoryInterface $token_meta_repository,
		WhitelistInterface $whitelist,
		BalanceFactoryInterface $balance_factory,
		array $items
	) {
		parent::__construct( $items );
		$this->token_meta_repository = $token_meta_repository;
		$this->meta_repository = $meta_repository;
		$this->whitelist = $whitelist;
		$this->balance_factory = $balance_factory;
	}

	/**
	 * Applies the whitelist to the balances
	 * @return array
	 */
	public function apply_whitelist() {
		if ( $this->whitelist->enabled == true ) {
			$items = $this->whitelist->items ?? null;
			
			$balances_filtered = array();
			if ( $items ) {
				foreach ( $items as $item ) {
					$whitelist_rule = implode( ':', array_filter( array( $item->address, $item->index ) ) );
					$assets = array_column( (array) $this, 'asset' );
					
					$search = array_search( $whitelist_rule, $assets );
					if ( $search !== false ) {
						$balances_filtered[] = $this[ $search ];
					}
				}
			}
			$this->exchangeArray( $balances_filtered );
		}
	}

	/**
	 * Embeds the WordPress token meta post data into the balance objects
	 * @return array
	 */
	public function with_meta() {
		$assets = array_map( function( $balance ) {
			return $balance->name;
		}, ( array ) $this );
		$query_meta = $this->token_meta_repository->index( array(
			'assets' => $assets,
		) );
		$balances_keyed = array();
		foreach( ( array ) $this as $balance ) {
			$balances_keyed[ $balance->name ] = $balance;
		}
		while ( $query_meta->have_posts() ) {
			$query_meta->the_post();
			$post_id = get_the_ID();
			$meta_item = array();
			$meta_item['name'] = get_the_title();
			$meta_item['image'] = get_the_post_thumbnail( $post_id, 'full' );
			$meta_item['description'] = get_the_excerpt();
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
	}
}
