<?php

namespace Tokenly\Wp\Repositories;

use Tokenly\TokenpassClient\TokenpassAPIInterface;
use Tokenly\Wp\Interfaces\Repositories\General\UserMetaRepositoryInterface;
use Tokenly\Wp\Interfaces\Repositories\BalanceRepositoryInterface;
use Tokenly\Wp\Interfaces\Factories\BalanceCollectionFactoryInterface;
use Tokenly\Wp\Interfaces\Factories\BalanceFactoryInterface;

/**
 * Manages token balance
 */
class BalanceRepository implements BalanceRepositoryInterface {
	protected $client;
	protected $user_meta_repository;
	protected $balance_factory;
	
	public function __construct(
		TokenpassAPIInterface $client,
		UserMetaRepositoryInterface $user_meta_repository,
		BalanceCollectionFactoryInterface $balance_collection_factory,
		BalanceFactoryInterface $balance_factory
	) {
		$this->client = $client;
		$this->user_meta_repository = $user_meta_repository;
		$this->balance_collection_factory = $balance_collection_factory;
		$this->balance_factory = $balance_factory;
	}

	/**
	 * Fetches the current token balance for the specific user,
	 * applies whitelist and embeds the token meta
	 * @param array $params Index parameters
	 * @return array $balances
	 */
	public function index( $oauth_token, $whitelist = true, $meta = true ) {
		$balances = $this->client->getCombinedPublicBalances( $oauth_token );
		$balances = array_map( function( $balance_data ) {
			return $this->balance_factory->create( $balance_data );
		}, $balances );
		$balances = $this->balance_collection_factory->create( $balances );
		if ( $whitelist == true ) {
			//$balances = $this->balance_service->apply_whitelist( $balances );
		}
		if ( $meta == true ) {
			//$balances = $this->balance_service->embed_token_meta( $balances );
		}
		return $balances;
	}
}
