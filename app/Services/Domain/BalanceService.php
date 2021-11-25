<?php

namespace Tokenly\Wp\Services\Domain;

use Tokenly\Wp\Services\Domain\DomainService;
use Tokenly\Wp\Interfaces\Services\Domain\BalanceServiceInterface;
use Tokenly\Wp\Interfaces\Services\Domain\TokenMetaServiceInterface;
use Tokenly\Wp\Interfaces\Repositories\BalanceRepositoryInterface;
use Tokenly\Wp\Interfaces\Collections\BalanceCollectionInterface;

class BalanceService extends DomainService implements BalanceServiceInterface {
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
			$balances = $this->load( $balances, $params['with'] );
		}
		return $balances;
	}

	/**
	 * Embeds the WordPress token meta post data into the balance objects
	 * @param BalanceCollectionInterface $balances Queried balances
	 * @return BalanceCollectionInterface
	 */
	protected function load_token_meta_collection( BalanceCollectionInterface $balances, array $relation ) {
		$assets = array_map( function( $balance ) {
			return $balance->name;
		}, ( array ) $balances );
		$meta = $this->token_meta_service->index( array(
			'assets' => $assets,
			'with'   => $relation,
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
