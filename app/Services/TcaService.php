<?php

namespace Tokenly\Wp\Services;

use Tokenly\Wp\Interfaces\Services\TcaServiceInterface;
use Tokenly\Wp\Interfaces\Collections\TcaRuleCollectionInterface;
use Tokenly\TokenpassClient\TokenpassAPIInterface;
use Tokenly\Wp\Interfaces\Services\Domain\OauthUserServiceInterface;

/**
 * Handles version changes
 */
class TcaService implements TcaServiceInterface {
	protected $client;
	protected $oauth_user_service;

	public function __construct(
		TokenpassAPIInterface $client,
		OauthUserServiceInterface $oauth_user_service
	) {
		$this->client = $client;	
		$this->oauth_user_service = $oauth_user_service;
	}

	public function check_token_access_user( int $user_id, TcaRuleCollectionInterface $rules ) {
		$user = $this->oauth_user_service->show( $user_id );
		if ( !$user ) {
			return false;
		}
		$this->client->checkTokenAccess($user->username, $rules, $oauth_token);
	}
}
