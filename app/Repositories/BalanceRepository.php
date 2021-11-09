<?php

namespace Tokenly\Wp\Repositories;

use Tokenly\TokenpassClient\TokenpassAPIInterface;
use Tokenly\Wp\Interfaces\Repositories\General\UserMetaRepositoryInterface;
use Tokenly\Wp\Interfaces\Services\BalanceServiceInterface;
use Tokenly\Wp\Interfaces\Repositories\BalanceRepositoryInterface;
/**
 * Manages token balance
 */
class BalanceRepository implements BalanceRepositoryInterface {
	protected $client;
	protected $user_meta_repository;
	protected $balance_service;
	
	public function __construct(
		TokenpassAPIInterface $client,
		UserMetaRepositoryInterface $user_meta_repository,
		BalanceServiceInterface $balance_service
	) {
		$this->client = $client;
		$this->user_meta_repository = $user_meta_repository;
		$this->balance_service = $balance_service;
	}

	/**
	 * Fetches the current token balance for the specific user,
	 * applies whitelist and embeds the token meta
	 * @param array $params Index parameters
	 * @return array $balances
	 */
	public function index( $user_id, $whitelist = true, $meta = true ) {
		if ( $user_id == 'me' ) {
			$user_id = get_current_user_id();
		}
		$oauth_token = $this->user_meta_repository->show( $user_id, 'oauth_token' );
		if ( !$oauth_token ) {	
			return;
		}
		$balances = $this->client->getCombinedPublicBalances( $oauth_token );
		error_log(print_r( $balances, true ));
		if ( $whitelist == true ) {
			$balances = $this->balance_service->apply_whitelist( $balances );
		}
		if ( $meta == true ) {
			$balances = $this->balance_service->embed_token_meta( $balances );
		}
		return $balances;
	}
}
