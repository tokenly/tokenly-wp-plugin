<?php

namespace Tokenly\Wp\Repositories;

use Tokenly\TokenpassClient\TokenpassAPIInterface;
use Tokenly\Wp\Interfaces\Repositories\OauthUserRepositoryInterface;
use Tokenly\Wp\Interfaces\Factories\Models\OauthUserFactoryInterface;
use Tokenly\Wp\Interfaces\Models\OauthUserInterface;

class OauthUserRepository implements OauthUserRepositoryInterface {
	protected $client;
	protected $oauth_user_factory;
	
	public function __construct(
		TokenpassAPIInterface $client,
		OauthUserFactoryInterface $oauth_user_factory
	) {
		$this->client = $client;
		$this->oauth_user_factory = $oauth_user_factory;
	}

	/**
	 * Retrieves the OAuth user using an OAuth token
	 * @param string $oauth_token OAuth token of the user to retrieve
	 * @return OauthUserInterface
	 */
	public function show( string $oauth_token ) {
		$oauth_user;
		if ( isset( $params['oauth_token'] ) ) {
			$oauth_token = $params['oauth_token'];
			$oauth_user = $this->client->getUserByToken( $oauth_token );
			if ( is_array( $oauth_user ) ) {
				$oauth_user['oauth_token'] = $oauth_token;
			}
		} elseif ( isset( $params['address'] ) ) {
			$address = '14eRVGNPQChSmSmNLH6RPjdwsNPc7rH2Z7';
			$oauth_user = $this->client->lookupUserByAddress( $address );
		}
		if ( !$oauth_user ) {
			return;
		}
		$oauth_user = $this->oauth_user_factory->create( $oauth_user );
		return $oauth_user;
	}
}
