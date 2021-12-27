<?php

namespace Tokenly\Wp\Repositories\Token;

use Tokenly\Wp\Interfaces\Repositories\Token\BalanceRepositoryInterface;

use Tokenly\TokenpassClient\TokenpassAPIInterface;
use Tokenly\Wp\Interfaces\Factories\Collections\Token\BalanceCollectionFactoryInterface;
use Tokenly\Wp\Interfaces\Collections\Token\BalanceCollectionInterface;
use Tokenly\Wp\Interfaces\Factories\Models\Token\QuantityFactoryInterface;

/**
 * Manages token balance
 */
class BalanceRepository implements BalanceRepositoryInterface {
	protected $client;
	protected $balance_collection_factory;
	protected $quantity_factory;
	protected $balances_cache = array();
	
	public function __construct(
		TokenpassAPIInterface $client,
		BalanceCollectionFactoryInterface $balance_collection_factory,
		QuantityFactoryInterface $quantity_factory
	) {
		$this->client = $client;
		$this->balance_collection_factory = $balance_collection_factory;
		$this->quantity_factory = $quantity_factory;
	}

	/**
	 * Gets a collection of balance
	 * @param array $params Search parameters 
	 * @return BalanceCollectionFactoryInterface $balance
	 */
	public function index( array $params = array() ) {
		$balance = array();
		if ( isset( $params['oauth_token'] ) ) {
			$oauth_token = $params['oauth_token'];
			$balance = $this->client->getCombinedPublicBalances( $oauth_token );
			if ( $balance && is_array( $balance ) ) {
				foreach ( $balance as &$balance_item ) {
					$balance_item = $this->remap_fields( $balance_item );
				}
			} else {
				$balance = array();
			}
		}
		$balance = $this->balance_collection_factory->create( $balance, array(
			'use_whitelist' => $params['use_whitelist'] ?? true,
		) );
		return $balance;
	}

	/**
	 * Formats the received item
	 * @param array $balance Balance received
	 * @return array $balance Formatted balance
	 */
	protected function remap_fields( array $balance = array() ) {
		$value = 0;
		if ( isset( $balance['balance'] ) ) {
			$value = $balance['balance'];
			unset( $balance['balance'] );
		}
		$value_sat = 0;
		if ( isset( $balance['balanceSat'] ) ) {
			$value_sat = $balance['balanceSat'];
			unset( $balance['balanceSat'] );
		}
		$precision = 0;
		if ( isset( $balance['precision'] ) ) {
			$precision = $balance['precision'];
			unset( $balance['precision'] );
		}
		$balance['quantity'] = $this->quantity_factory->create( array(
			'value'     => $value,
			'value_sat' => $value_sat,
			'precision' => $precision,
		) );
		return $balance;
	}
}
