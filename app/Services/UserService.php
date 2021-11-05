<?php

namespace Tokenly\Wp\Services;

use Tokenly\Wp\Interfaces\Services\UserServiceInterface;
use Tokenly\Wp\Interfaces\Repositories\Post\TokenMetaRepositoryInterface;
use Tokenly\Wp\Interfaces\Repositories\WhitelistRepositoryInterface;
use Tokenly\TokenpassClient\TokenpassAPIInterface;

/**
 * Handles the WordPress user operations
 */
class UserService implements UserServiceInterface {
	public $client;
	public $token_meta_repository;

	public function __construct(
		TokenpassAPIInterface $client,
		TokenMetaRepositoryInterface $token_meta_repository,
		WhitelistRepositoryInterface $whitelist_repository
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
