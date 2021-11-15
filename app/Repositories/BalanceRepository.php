<?php

namespace Tokenly\Wp\Repositories;

use Tokenly\TokenpassClient\TokenpassAPIInterface;
use Tokenly\Wp\Interfaces\Repositories\BalanceRepositoryInterface;
use Tokenly\Wp\Interfaces\Factories\Collections\BalanceCollectionFactoryInterface;
use Tokenly\Wp\Interfaces\Collections\BalanceCollectionInterface;
use Tokenly\Wp\Interfaces\Repositories\Post\TokenMetaRepositoryInterface;

/**
 * Manages token balance
 */
class BalanceRepository implements BalanceRepositoryInterface {
	protected $client;
	protected $balance_collection_factory;
	
	public function __construct(
		TokenpassAPIInterface $client,
		BalanceCollectionFactoryInterface $balance_collection_factory,
		TokenMetaRepositoryInterface $token_meta_repository
	) {
		$this->client = $client;
		$this->balance_collection_factory = $balance_collection_factory;
		$this->token_meta_repository = $token_meta_repository;
	}

	/**
	 * Fetches the current token balance for the specific user
	 * @param string $oauth_token User oauth token
	 * @param bool $use_whitelist Filter the collection using the whitelist
	 * @param bool $use_meta Append additional token meta to the collection
	 * @return BalanceCollectionFactoryInterface $balances
	 */
	public function index( $oauth_token, array $params = array() ) {
		$balances = $this->client->getCombinedPublicBalances( $oauth_token );
		$balances = $this->balance_collection_factory->create( $balances, array(
			'use_whitelist' => $params['use_whitelist'] ?? null,
		) );
		if ( isset( $params['with'] ) ) {
			$balances = $this->handle_with( $balances, $params['with'] );
		}
		return $balances;
	}

	/**
	 * Handles queries using parameter 'with'
	 * @param BalanceCollectionInterface $sources Queried sources
	 * @return BalanceCollectionInterface Modified sources
	 */
	protected function handle_with( BalanceCollectionInterface $balances, array $with ) {
		if ( in_array( 'meta', $with ) ) {
			$balances = $this->handle_with_meta( $balances );
		}
		return $balances;
	}

		/**
	 * Embeds the WordPress token meta post data into the balance objects
	 * @param BalanceCollectionInterface $balances Queried balances
	 * @return BalanceCollectionInterface
	 */
	public function handle_with_meta( BalanceCollectionInterface $balances ) {
		$assets = array_map( function( $balance ) {
			return $balance->name;
		}, ( array ) $balances );
		$meta = $this->token_meta_repository->index( array(
			'assets' => $assets,
		) );
		$balances = $balances->key_by_field( 'asset' );
		$meta_keyed = array();
		foreach ( ( array ) $meta as $meta_item ) {
			$asset = $meta_item->tokenly_asset;
			$meta_keyed[ $asset ] = $meta_item;
		}
		$balances = array_map( function( $balance ) use ( $meta_keyed ) {
			$asset = $balance->asset;
			if ( !$asset ) {
				return $balance;
			}
			$meta = $meta_keyed[ $balance->asset ] ?? null;
			if ( !$meta ) {
				return $balance;
			}
			$balance->meta = $meta;
			return $balance;
		}, ( array ) $balances );
		return $balances;
	}
}
