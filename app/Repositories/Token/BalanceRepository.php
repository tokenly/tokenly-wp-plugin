<?php

namespace Tokenly\Wp\Repositories\Token;

use Tokenly\Wp\Repositories\Repository;
use Tokenly\Wp\Interfaces\Repositories\Token\BalanceRepositoryInterface;

use Tokenly\Wp\Collections\Token\BalanceCollection;
use Tokenly\Wp\Models\Token\Balance;
use Tokenly\Wp\Interfaces\Collections\Token\BalanceCollectionInterface;
use Tokenly\Wp\Interfaces\Models\Token\BalanceInterface;
use Tokenly\Wp\Interfaces\Models\Token\MetaInterface;
use Tokenly\Wp\Interfaces\Models\Token\WhitelistInterface;
use Tokenly\Wp\Interfaces\Repositories\Token\MetaRepositoryInterface;
use Tokenly\Wp\Interfaces\Repositories\Token\WhitelistRepositoryInterface;
use Tokenly\Wp\Interfaces\Services\Domain\Token\AssetNameFormatterServiceInterface;
use Tokenly\Wp\Interfaces\Collections\Token\CategoryTermCollectionInterface;
use Tokenly\TokenpassClient\TokenpassAPIInterface;

/**
 * Manages token balance
 */
class BalanceRepository extends Repository 
	implements BalanceRepositoryInterface
{
	protected MetaRepositoryInterface $meta_repository;
	protected WhitelistRepositoryInterface $whitelist_repository;
	protected WhitelistInterface $whitelist;
	protected TokenpassAPIInterface $client;
	protected AssetNameFormatterServiceInterface $asset_name_formatter_service;
	
	public function __construct(
		MetaRepositoryInterface $meta_repository,
		WhitelistRepositoryInterface $whitelist_repository,
		TokenpassAPIInterface $client,
		AssetNameFormatterServiceInterface $asset_name_formatter_service
	) {
		$this->client = $client;
		$this->meta_repository = $meta_repository;
		$this->whitelist_repository = $whitelist_repository;
		$this->whitelist = $this->whitelist_repository->show();
		$this->asset_name_formatter_service = $asset_name_formatter_service;
	}

	/**
	 * Gets a collection of balances
	 * @param array $params Search parameters
	 * @return BalanceCollectionInterface Balances found
	 */
	public function index(
		array $params = array()
	): BalanceCollectionInterface {
		return $this->handle_method( __FUNCTION__, func_get_args() );
	}

	/**
	 * Implementation of the "index" method. Will only
	 * run if no cached instance was found.
	 * @param array $params Search parameters
	 * @return BalanceCollectionInterface Balances found
	 */
	protected function index_cacheable(
		array $params = array()
	): BalanceCollectionInterface {
		$balance = array();
		if ( isset( $params['oauth_token'] ) ) {
			$oauth_token = $params['oauth_token'];
			$balance = 
				$this->client->getCombinedPublicBalances( $oauth_token );
			if ( $balance && is_array( $balance ) ) {
				foreach ( $balance as &$balance_item ) {
					$balance_item = $this->format_item( $balance_item );
				}
			} else {
				$balance = array();
			}
		}
		$balance = ( new BalanceCollection() )->from_array( $balance );
		$balance->apply_whitelist( $this->whitelist );
		return $balance;
	}

	/**
	 * @inheritDoc
	 */
	protected function format_item( array $item = array() ): array {
		$item['asset'] = $this->asset_name_formatter_service->split(
			$item['asset']
		);
		$value = 0;
		if ( isset( $item['balance'] ) ) {
			$value = $item['balance'];
			unset( $item['balance'] );
		}
		$value_sat = 0;
		if ( isset( $item['balanceSat'] ) ) {
			$value_sat = $item['balanceSat'];
			unset( $item['balanceSat'] );
		}
		$precision = 0;
		if ( isset( $item['precision'] ) ) {
			$precision = $item['precision'];
			unset( $item['precision'] );
		}
		$item['quantity'] = array(
			'value'     => $value,
			'value_sat' => $value_sat,
			'precision' => $precision,
		);
		return $item;
	}

	/**
	 * Loads the meta relation
	 * @param BalanceInterface $balance Target balance
	 * @param string[] $relations Further relations
	 * @return MetaInterface|null
	 */
	protected function load_meta(
		BalanceInterface $balance,
		array $relations = array()
	): ?MetaInterface {
		$meta = $this->meta_repository->show( array(
			'assets' => array( $balance->asset->name ),
			'with'   => $relations,
		) );
		return $meta;
	}
}
