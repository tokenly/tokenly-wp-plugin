<?php

namespace Tokenly\Wp\Repositories;

use Tokenly\TokenpassClient\TokenpassAPI;
use Tokenly\Wp\Repositories\General\UserMetaRepository;
use Tokenly\Wp\Services\BalanceService;
/**
 * Manages token balance
 */
class BalanceRepository {
	public $client;
	public $user_meta_repository;
	public $balance_service;
	
	public function __construct(
		TokenpassAPI $client,
		UserMetaRepository $user_meta_repository,
		BalanceService $balance_service
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
		if ( $whitelist == true ) {
			$balances = $this->balance_service->apply_whitelist( $balances );
		}
		if ( $meta == true ) {
			$balances = $this->balance_service->embed_token_meta( $balances );
		}
		return $balances;
	}
}
