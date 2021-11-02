<?php

namespace Tokenly\Wp\Services;

use Tokenly\TokenpassClient\TokenpassAPI;
use Tokenly\Wp\Repositories\Post\TokenMetaRepository;
use Tokenly\Wp\Repositories\WhitelistRepository;

class UserService {
	public $client;
	public $token_meta_repository;

	public function __construct(
		TokenpassAPI $client,
		TokenMetaRepository $token_meta_repository,
		WhitelistRepository $whitelist_repository
	) {
		$this->client = $client;
		$this->token_meta_repository = $token_meta_repository;
		$this->whitelist_repository = $whitelist_repository;
	}

	public function get_by_uuid( $uuid ) {
		$params = array(
			'number' => 1,
			'meta_query' => array(
				array(
					'key'     => 'tokenly_uuid',
					'value'   => $uuid,
				),
			)
		);
		$user_query = new \WP_User_Query( $params );
		if ( ! empty( $user_query->results ) ) {
			$user = $user_query->results[0] ?? null;
			if ( $user ) {
				return $user;
			}
		}
	}
	
	public function filter_balances( $balances ) {
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
			$id = get_the_ID();
			$meta_item = array();
			$meta_item['name'] = get_the_title();
			$meta_item['image'] = get_the_post_thumbnail( $id, 'full' );
			$meta_item['description'] = get_the_excerpt();
			$asset = get_post_meta( $id, 'tokenly_asset' );
			if ( $asset ) {
				$asset = $asset[0] ?? null;
				$meta_item['asset'] = $asset;
				if ( $balances_keyed[ $asset ] ?? null ) {
					$balances_keyed[ $asset ]['meta'] = $meta_item;
				}
			}
		}
		return $balances_keyed;
	}

	public function get_inventory( $user_id ) {
		$oauth_token = get_user_meta( $user_id, 'tokenly_oauth_token' );
		if ( $oauth_token ) {		
			$oauth_token = $oauth_token[0];
			$balances = $this->client->getCombinedPublicBalances( $oauth_token );
			$balances = $this->filter_balances( $balances );
			$balances = $this->embed_token_meta( $balances );
			return $balances;
		}
	}
}
