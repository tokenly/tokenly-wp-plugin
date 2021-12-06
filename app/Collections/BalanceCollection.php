<?php

/**
 * Collection of Balance objects
 */

namespace Tokenly\Wp\Collections;

use Tokenly\Wp\Interfaces\Collections\BalanceCollectionInterface;
use Tokenly\Wp\Interfaces\Models\BalanceInterface;
use Tokenly\Wp\Interfaces\Models\Settings\WhitelistSettingsInterface;
use Tokenly\Wp\Interfaces\Factories\Models\BalanceFactoryInterface;
use Tokenly\Wp\Interfaces\Services\Domain\TokenMetaServiceInterface;
use Tokenly\Wp\Collections\Collection;

class BalanceCollection extends Collection implements BalanceCollectionInterface {
	protected $item_type = BalanceInterface::class;

	public function __construct(
		WhitelistSettingsInterface $whitelist,
		BalanceFactoryInterface $balance_factory,
		TokenMetaServiceInterface $token_meta_service,
		array $items
	) {
		$this->whitelist = $whitelist;
		$this->balance_factory = $balance_factory;
		$this->token_meta_service = $token_meta_service;
		parent::__construct( $items );
	}

	/**
	 * Applies the whitelist to the balances
	 * @return array
	 */
	public function apply_whitelist() {
		if ( $this->whitelist->enabled == true ) {
			$items = $this->whitelist->items ?? null;
			
			$balances_filtered = array();
			if ( $items ) {
				foreach ( $items as $item ) {
					$whitelist_rule = implode( ':', array_filter( array( $item->address, $item->index ) ) );
					$assets = array_column( (array) $this, 'asset' );
					
					$search = array_search( $whitelist_rule, $assets );
					if ( $search !== false ) {
						$balances_filtered[] = $this[ $search ];
					}
				}
			}
			$this->exchangeArray( $balances_filtered );
		}
	}

	/**
	 * Loads the token meta relation
	 * @param array $relation Further relations
	 * @return self
	 */
	protected function load_token_meta( array $relations ) {
		$assets = array_map( function( BalanceInterface $balance ) {
			return $balance->name;
		}, ( array ) $this );
		$meta = $this->token_meta_service->index( array(
			'assets' => $assets,
			'with'   => $relations,
		) );
		$meta_keyed = array();
		foreach ( ( array ) $meta as $meta_item ) {
			$asset = $meta_item->tokenly_asset;
			$meta_keyed[ $asset ] = $meta_item;
		}
		foreach ( (array) $this as &$balance ) {
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
		return $this;
	}
}
