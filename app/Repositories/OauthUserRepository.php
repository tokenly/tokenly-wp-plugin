<?php

namespace Tokenly\Wp\Repositories;

use Tokenly\TokenpassClient\TokenpassAPIInterface;
use Tokenly\Wp\Interfaces\Repositories\OauthUserRepositoryInterface;
use Tokenly\Wp\Interfaces\Repositories\General\UserMetaRepositoryInterface;
use Tokenly\Wp\Interfaces\Factories\Models\OauthUserFactoryInterface;

class OauthUserRepository implements OauthUserRepositoryInterface {
	protected $client;
	protected $user_meta_repository;
	protected $oauth_user_factory;
	protected $user_cache = array();
	
	public function __construct(
		TokenpassAPIInterface $client,
		UserMetaRepositoryInterface $user_meta_repository,
		OauthUserFactoryInterface $oauth_user_factory
	) {
		$this->client = $client;
		$this->user_meta_repository = $user_meta_repository;
		$this->oauth_user_factory = $oauth_user_factory;
	}

	public function show( int $user_id ) {
		$oauth_token = $this->user_meta_repository->show( $user_id, 'oauth_token' );
		if ( !$oauth_token ) {
			return;
		}
		if ( isset( $this->user_cache[ $oauth_token ] ) ) {
			$oauth_token = $this->user_cache[ $oauth_user ];
		} else {
			$oauth_user = $this->client->getUserByToken( $oauth_token );
			$this->user_cache[ $oauth_token ] = $oauth_user;
		}
		if ( !$oauth_user ) {
			return;
		}
		$oauth_user = $this->oauth_user_factory->create( $oauth_user );
		return $oauth_user;
	}
}
