<?php

namespace Tokenly\Wp\Services\Domain;

use Tokenly\Wp\Services\Domain\DomainService;
use Tokenly\Wp\Interfaces\Services\Domain\OauthUserServiceInterface;
use Tokenly\Wp\Interfaces\Repositories\OauthUserRepositoryInterface;
use Tokenly\Wp\Interfaces\Repositories\General\UserMetaRepositoryInterface;

/**
 * Manages the OAuth users
 */
class OauthUserService extends DomainService implements OauthUserServiceInterface {
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
	
	/**
	 * Retrieves a single OAuth user object
	 * @param array $params Search parameters
	 * @return OauthUserInterface 
	 */
	public function show( array $params = array() ) {
		$oauth_token;
		if ( isset( $params['id'] ) ) {
			$user_id = $params['id'];
			$oauth_token = $this->user_meta_repository->show( $user_id, 'oauth_token' );
			$params['oauth_token'] = $oauth_token;
		}
		$oauth_user = $this->oauth_user_repository->show( $params );
		if ( !$oauth_user ) {
			return;
		}
		return $oauth_user;
	}
}
