<?php

namespace Tokenly\Wp\Services;

use Tokenly\Wp\Repositories\General\MetaRepository;
use Tokenly\Wp\Repositories\Post\TokenMetaRepository;
use Tokenly\Wp\Repositories\WhitelistRepository;

/**
 * Handles the token whitelist operations
 */
class BalanceService {
	public $token_meta_repository;
	public $meta_repository;
	public $whitelist_repository;

	public function __construct(
		MetaRepository $meta_repository,
		TokenMetaRepository $token_meta_repository,
		WhitelistRepository $whitelist_repository
	) {
		$this->token_meta_repository = $token_meta_repository;
		$this->meta_repository = $meta_repository;
		$this->whitelist_repository = $whitelist_repository;
	}

	/**
	 * Applies the whitelist to the balances
	 * @param array $balances Token balances
	 * @return array
	 */
	public function apply_whitelist( $balances ) {
		$whitelist = $this->whitelist_repository->show();
		$use_whitelist = $whitelist['use_whitelist'] ?? null;
		if ( $use_whitelist && $use_whitelist == true ) {
			$whitelist_rules = $whitelist['whitelist'] ?? null;
			$balances_filtered = array();
			if ( $whitelist_rules ) {
				foreach ( $whitelist_rules as $whitelist_rule ) {
					$address = $whitelist_rule['address'] ?? null;
					$index = $whitelist_rule['index'] ?? null;
					$whitelist_rule = implode( ':', array_filter( array( $address, $index ) ) );
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
			return $balance['name'] ?? null;
		}, $balances );
		$query_meta = $this->token_meta_repository->index( array(
			'assets' => $assets,
		) );
		$balances_keyed = array();
		foreach( $balances as $balance ) {
			$balances_keyed[ $balance['name'] ] = $balance;
		}
		$meta = array();
		while ( $query_meta->have_posts() ) {
			$query_meta->the_post();
			$post_id = get_the_ID();
			$meta_item = array();
			$meta_item['name'] = get_the_title();
			$meta_item['image'] = get_the_post_thumbnail( $post_id, 'full' );
			$meta_item['description'] = get_the_excerpt();
			$asset = $this->meta_repository->show( $post_id, 'asset' );
			if ( $asset ) {
				$meta_item['asset'] = $asset;
				if ( $balances_keyed[ $asset ] ?? null ) {
					$balances_keyed[ $asset ]['meta'] = $meta_item;
				}
			}
		}
		return $balances_keyed;
	}
}
