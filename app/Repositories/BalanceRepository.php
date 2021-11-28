<?php

namespace Tokenly\Wp\Repositories;

use Tokenly\TokenpassClient\TokenpassAPIInterface;
use Tokenly\Wp\Interfaces\Repositories\BalanceRepositoryInterface;
use Tokenly\Wp\Interfaces\Factories\Collections\BalanceCollectionFactoryInterface;
use Tokenly\Wp\Interfaces\Collections\BalanceCollectionInterface;

/**
 * Manages token balance
 */
class BalanceRepository implements BalanceRepositoryInterface {
	protected $client;
	protected $balance_collection_factory;
	protected $balances_cache = array();
	
	public function __construct(
		TokenpassAPIInterface $client,
		BalanceCollectionFactoryInterface $balance_collection_factory
	) {
		$this->client = $client;
		$this->balance_collection_factory = $balance_collection_factory;
	}

	/**
	 * Fetches the current token balance for the specific user
	 * @param string $oauth_token User oauth token
	 * @param bool $use_whitelist Filter the collection using the whitelist
	 * @param bool $use_meta Append additional token meta to the collection
	 * @return BalanceCollectionFactoryInterface $balances
	 */
	public function index( $oauth_token, array $params = array() ) {
		$balances = $this->client->getCombinedPublicBalances( $oauth_token ) ?? array();
		$balances = $this->balance_collection_factory->create( $balances, array(
			'use_whitelist' => $params['use_whitelist'] ?? true,
		) );
		return $balances;
	}
}
