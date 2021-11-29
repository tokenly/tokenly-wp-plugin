<?php

namespace Tokenly\Wp\Services;

use Tokenly\Wp\Interfaces\Services\TcaServiceInterface;
use Tokenly\Wp\Interfaces\Collections\TcaRuleCollectionInterface;
use Tokenly\TokenpassClient\TokenpassAPIInterface;
use Tokenly\Wp\Interfaces\Services\Domain\UserServiceInterface;

/**
 * Handles version changes
 */
class TcaService implements TcaServiceInterface {
	protected $client;
	protected $user_service;

	public function __construct(
		TokenpassAPIInterface $client,
		UserServiceInterface $user_service
	) {
		$this->client = $client;	
		$this->user_service = $user_service;
	}

	public function check_token_access_user( int $user_id, TcaRuleCollectionInterface $rules ) {
		$user = $this->user_service->show( array( 'id' => $user_id ) );
		if ( !$user ) {
			return false;
		}
		$oauth_user = $user->get_oauth_user();
		if ( !$oauth_user ) {
			return false;
		}
		$oauth_token = $user->get_oauth_token();
		if ( !$oauth_token ) {
			return false;
		}
		$username = $oauth_user->username;
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
