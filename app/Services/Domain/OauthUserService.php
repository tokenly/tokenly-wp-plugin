<?php

namespace Tokenly\Wp\Services\Domain;

use Tokenly\Wp\Interfaces\Services\Domain\OauthUserServiceInterface;
use Tokenly\Wp\Interfaces\Repositories\OauthUserRepositoryInterface;
use Tokenly\Wp\Interfaces\Repositories\General\UserMetaRepositoryInterface;

class OauthUserService implements OauthUserServiceInterface {
	protected $oauth_user_cache = array();
	protected $oauth_user_repository;
	protected $user_meta_repository;

	public function __construct(
		OauthUserRepositoryInterface $oauth_user_repository,
		UserMetaRepositoryInterface $user_meta_repository
	) {
		$this->oauth_user_repository = $oauth_user_repository;
		$this->user_meta_repository = $user_meta_repository;
	}
	
	public function show( int $user_id ) {
		$oauth_token = $this->user_meta_repository->show( $user_id, 'oauth_token' );
		if ( !$oauth_token ) {
			return;
		}
		$oauth_user;
		if ( isset( $this->user_cache[ $oauth_token ] ) ) {
			$oauth_token = $this->user_cache[ $oauth_user ];
		} else {
			$oauth_user = $this->oauth_user_repository->show( $oauth_token );
			$this->user_cache[ $oauth_token ] = $oauth_user;
		}
		return $oauth_user;
	}
}
