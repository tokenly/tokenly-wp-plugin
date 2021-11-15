<?php

/**
 * Collection of Balance objects
 */

namespace Tokenly\Wp\Collections;

use Tokenly\Wp\Interfaces\Repositories\General\MetaRepositoryInterface;
use Tokenly\Wp\Interfaces\Repositories\Post\TokenMetaRepositoryInterface;
use Tokenly\Wp\Interfaces\Collections\BalanceCollectionInterface;
use Tokenly\Wp\Interfaces\Models\BalanceInterface;
use Tokenly\Wp\Interfaces\Models\WhitelistInterface;
use Tokenly\Wp\Interfaces\Factories\Models\BalanceFactoryInterface;
use Tokenly\Wp\Collections\Collection;

class BalanceCollection extends Collection implements BalanceCollectionInterface {
	protected $item_type = BalanceInterface::class;

	public function __construct(
		MetaRepositoryInterface $meta_repository,
		TokenMetaRepositoryInterface $token_meta_repository,
		WhitelistInterface $whitelist,
		BalanceFactoryInterface $balance_factory,
		array $items
	) {
		parent::__construct( $items );
		$this->token_meta_repository = $token_meta_repository;
		$this->meta_repository = $meta_repository;
		$this->whitelist = $whitelist;
		$this->balance_factory = $balance_factory;
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
}
