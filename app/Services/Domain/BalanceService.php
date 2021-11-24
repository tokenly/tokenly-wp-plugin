<?php

namespace Tokenly\Wp\Services\Domain;

use Tokenly\Wp\Interfaces\Services\Domain\BalanceServiceInterface;
use Tokenly\Wp\Interfaces\Services\Domain\TokenMetaServiceInterface;
use Tokenly\Wp\Interfaces\Repositories\BalanceRepositoryInterface;

class BalanceService implements BalanceServiceInterface {
	protected $balance_cache = array();
	protected $balance_repository;
	protected $token_meta_service;

	public function __construct(
		BalanceRepositoryInterface $balance_repository,
		TokenMetaServiceInterface $token_meta_service
	) {
		$this->balance_repository = $balance_repository;
		$this->token_meta_service = $token_meta_service;
	}

	public function index( string $oauth_token, array $params = array() ) {
		$balances;
		if ( isset( $this->balances_cache[ $oauth_token ] ) ) {
			$balances = $this->balances_cache[ $oauth_token ];
		} else {
			$balances = $this->balance_repository->index( $oauth_token );
			$this->balances_cache[ $oauth_token ] = $balances;
		}
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
		$meta = $this->token_meta_service->index( array(
			'assets' => $assets,
		) );
		$balances = $balances->key_by_field( 'asset' );
		$meta_keyed = array();
		foreach ( ( array ) $meta as $meta_item ) {
			$asset = $meta_item->tokenly_asset;
			$meta_keyed[ $asset ] = $meta_item;
		}
		foreach ( (array) $balances as &$balance ) {
			$asset = $balance->asset;
			if ( !$asset ) {
				continue;
			}
			$meta = $meta_keyed[ $asset ] ?? null;
			if ( !$meta ) {
				continue;
			}
			$balance->meta = $meta;
		}
		return $balances;
	}
}
