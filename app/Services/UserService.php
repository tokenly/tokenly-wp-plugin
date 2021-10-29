<?php

namespace Tokenly\Wp\Services;

use Tokenly\TokenpassClient\TokenpassAPI;
use Tokenly\Wp\Repositories\Post\TokenMetaRepository;

class UserService {
	public $client;
	public $token_meta_repository;

	public function __construct(
		TokenpassAPI $client,
		TokenMetaRepository $token_meta_repository
	) {
		$this->client = $client;
		$this->token_meta_repository = $token_meta_repository;
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
		$settings = get_option( 'tokenpass_whitelist', array() );
		$use_whitelist = $settings['use_whitelist'] ?? null;
		if ( $use_whitelist && $use_whitelist === true ) {
			$whitelist = $settings['whitelist'] ?? null;
			$balances_filtered = array();
			if ( $whitelist ) {
				foreach ( $whitelist as $whitelist_rule ) {
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
		$balances = array_map( function( $balance ) {
			$token_meta_post = $this->token_meta_repository->show( array(
				'name' => $balance['name'] ?? null,
			) );
			if ( $token_meta_post ) {
				$description = get_the_excerpt( $token_meta_post );
				$image = get_the_post_thumbnail( $token_meta_post, 'full' );
				$balance['meta'] = array(
					'description' => $description,
					'image'       => $image,
				);
			}
			return $balance;
		}, $balances );
		return $balances;
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
