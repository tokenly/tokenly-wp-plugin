<?php

/**
 * Collection of Balance objects
 */

namespace Tokenly\Wp\Collections\Token;

use Tokenly\Wp\Collections\Collection;
use Tokenly\Wp\Interfaces\Collections\Token\BalanceCollectionInterface;

use Tokenly\Wp\Models\Token\Balance;
use Tokenly\Wp\Interfaces\Models\Token\WhitelistInterface;

class BalanceCollection extends Collection
	implements BalanceCollectionInterface
{
	protected string $item_type = Balance::class;

	/**
	 * Keys the collection by asset name
	 * @return self
	 */
	public function key_by_asset_name(): self {
		$keyed = array();
		foreach ( ( array ) $this as $item ) {
			if ( $item->asset ) {
				$name = $item->asset->name;
				$keyed[ $name ] = $item;
			}
		}
		$this->exchangeArray( $keyed );
		return $this;
	}

	/**
	 * Applies the whitelist to the balances
	 * @return void
	 */
	public function apply_whitelist( WhitelistInterface $whitelist ):void {
		if ( $whitelist->enabled == true ) {
			$items = $whitelist->items ?? null;
			$balances_filtered = array();
			if ( $items ) {
				$assets = array_map( function( $item ) {
					return $item->asset->name;
				}, ( array ) $this );	
				foreach ( ( array ) $items as $item ) {
					$asset = $item->asset;
					if ( !$asset ) {
						continue;
					}
					$search = array_search( $asset->name, $assets );
					if ( $search !== false ) {
						$balances_filtered[] = $this[ $search ];
					}
				}
			}
			$this->exchangeArray( $balances_filtered );
		}
	}
}
