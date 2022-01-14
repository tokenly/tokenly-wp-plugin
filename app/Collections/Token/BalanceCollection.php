<?php

/**
 * Collection of Balance objects
 */

namespace Tokenly\Wp\Collections\Token;

use Tokenly\Wp\Collections\Collection;
use Tokenly\Wp\Interfaces\Collections\Token\BalanceCollectionInterface;

use Tokenly\Wp\Interfaces\Models\Token\BalanceInterface;
use Tokenly\Wp\Interfaces\Models\Settings\WhitelistSettingsInterface;
use Tokenly\Wp\Interfaces\Factories\Models\Token\BalanceFactoryInterface;
use Tokenly\Wp\Interfaces\Services\Domain\Token\MetaServiceInterface;

class BalanceCollection extends Collection implements BalanceCollectionInterface {
	protected $item_type = BalanceInterface::class;
	protected $balance_factory;
	protected $meta_service;

	public function __construct(
		WhitelistSettingsInterface $whitelist,
		BalanceFactoryInterface $balance_factory,
		MetaServiceInterface $meta_service,
		array $items
	) {
		$this->whitelist = $whitelist;
		$this->balance_factory = $balance_factory;
		$this->meta_service = $meta_service;
		parent::__construct( $items );
		$this->apply_whitelist();
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
				foreach ( ( array ) $items as $item ) {
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
	 * Loads the meta relation
	 * @param string[] $relations Further relations
	 * @return self
	 */
	protected function load_meta( array $relations ) {
		$assets = array_map( function( BalanceInterface $balance ) {
			return $balance->name;
		}, ( array ) $this );
		$meta = $this->meta_service->index( array(
			'assets' => $assets,
			'with'   => $relations,
		) );
		$meta_keyed = array();
		foreach ( ( array ) $meta as $meta_item ) {
			$asset = $meta_item->asset;
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
