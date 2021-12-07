<?php

namespace Tokenly\Wp\Repositories;

use Tokenly\TokenpassClient\TokenpassAPIInterface;
use Tokenly\Wp\Interfaces\Repositories\OauthUserRepositoryInterface;
use Tokenly\Wp\Interfaces\Factories\Models\OauthUserFactoryInterface;
use Tokenly\Wp\Interfaces\Models\OauthUserInterface;

class OauthUserRepository implements OauthUserRepositoryInterface {
	protected $client;
	protected $oauth_user_factory;
	protected $cache_address = array();
	
	public function __construct(
		TokenpassAPIInterface $client,
		OauthUserFactoryInterface $oauth_user_factory
	) {
		$this->client = $client;
		$this->oauth_user_factory = $oauth_user_factory;
	}

	/**
	 * Retrieves a signle OAuth user
	 * @param array $params Search parameters
	 * @return OauthUserInterface
	 */
	public function show( array $params = array() ) {
		$oauth_user = null;
		if ( isset( $params['oauth_token'] ) ) {
			$oauth_user = $this->show_by_oauth_token( $params['oauth_token'] );
		} elseif ( isset( $params['address'] ) ) {
			$oauth_user = $this->show_by_address( $params['address'] );
		}
		if ( !$oauth_user ) {
			return false;
		}
		$oauth_user = $this->oauth_user_factory->create( $oauth_user );
		return $oauth_user;
	}

	/**
	 * Retrieves an OAuth user by address
	 * @param string $address Address to use for search
	 * @return array
	 */
	protected function show_by_address( string $address ) {
		$oauth_user = $this->client->lookupUserByAddress( $address );
		if ( !is_array( $oauth_user ) ) {
			return false;
		}
		$oauth_user = $oauth_user['result'];
		return $oauth_user;
	}

	/**
	 * Retrieves an OAuth user by OAuth token
	 * @param string $oauth_token OAuth token to use for search
	 * @return array
	 */
	protected function show_by_oauth_token( string $oauth_token ) {
		$oauth_user = $this->client->getUserByToken( $oauth_token );
		if ( !is_array( $oauth_user ) ) {
			return false;
		}
		$oauth_user['oauth_token'] = $oauth_token;
		return $oauth_user;
	}
}
