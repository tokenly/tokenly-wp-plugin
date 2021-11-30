<?php

namespace Tokenly\Wp\Services;

use Tokenly\Wp\Services\Service;
use Tokenly\Wp\Interfaces\Services\TcaServiceInterface;
use Tokenly\Wp\Interfaces\Collections\TcaRuleCollectionInterface;
use Tokenly\TokenpassClient\TokenpassAPIInterface;
use Tokenly\Wp\Interfaces\Services\Domain\UserServiceInterface;
use Tokenly\Wp\Interfaces\Models\OauthUserInterface;

/**
 * Handles version changes
 */
class TcaService extends Service implements TcaServiceInterface {
	protected $client;
	protected $user_service;

	public function __construct(
		TokenpassAPIInterface $client,
		UserServiceInterface $user_service
	) {
		$this->client = $client;	
		$this->user_service = $user_service;
	}

	public function check_token_access_user( OauthUserInterface $oauth_user, TcaRuleCollectionInterface $rules ) {
		$username = $oauth_user->username;
		$oauth_token = $oauth_user->oauth_token;
		if ( !$username || !$oauth_token ) {
			return;
		}
		$rules = $this->format_rules( $rules );
		$can_access = boolval( $this->client->checkTokenAccess( $username, $rules, $oauth_token ) ) ?? false;
		return $can_access;
	}

	protected function format_rules( TcaRuleCollectionInterface $rules ) {
		$rules_formatted = array();
		foreach ( $rules as $key => $rule ) {
			$rules_formatted[ $rule->asset ] = $rule->quantity;
			$rules_formatted[ "op_{$key}" ] = $rule->op; 
			if ( $key <= 0 ) {
				continue;
			}
			$rules_formatted[ "stackop_{$key}" ] = $rule->stackOp;
		}
		return $rules_formatted;
	}
}
