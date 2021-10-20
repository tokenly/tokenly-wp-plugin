<?php

namespace Tokenly\Wp\Services;

use Tokenly\Wp\Services\TokenlyService;
use Tokenly\TokenpassClient\TokenpassAPI;

class UserService {
	public $client;

	public function __construct( TokenpassAPI $client ) {
		$this->client = $client;
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

	public function get_inventory() {
		$user_id = get_current_user_id();
		$oauth_token = get_user_meta( $user_id, 'tokenly_oauth_token' );
		if ( $oauth_token ) {		
			$oauth_token = $oauth_token[0];
			$balances = $this->client->getCombinedPublicBalances( $oauth_token );
			return $balances;
		}
	}
}
