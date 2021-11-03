<?php

namespace Tokenly\Wp\Services;

use Tokenly\TokenpassClient\TokenpassAPI;
use Tokenly\Wp\Repositories\Post\TokenMetaRepository;
use Tokenly\Wp\Repositories\WhitelistRepository;

/**
 * Handles the WordPress user operations
 */
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

	/**
	 * Finds a WordPress user by Tokenpass UUID
	 * @param string $uuid Tokenpass UUID
	 * @return WP_User
	 */
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
}
