<?php

namespace Tokenly\Wp\Repositories;

use Tokenly\TokenpassClient\TokenpassAPIInterface;
use Tokenly\Wp\Interfaces\Repositories\OauthUserRepositoryInterface;
use Tokenly\Wp\Interfaces\Factories\Models\OauthUserFactoryInterface;

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

	public function show( $oauth_token ) {
		$oauth_user = $this->client->getUserByToken( $oauth_token );
		if ( !$oauth_user ) {
			return;
		}
		$oauth_user = $this->oauth_user_factory->create( $oauth_user );
		return $oauth_user;
	}
}
