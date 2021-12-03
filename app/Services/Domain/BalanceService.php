<?php

namespace Tokenly\Wp\Services\Domain;

use Tokenly\Wp\Services\Domain\DomainService;
use Tokenly\Wp\Interfaces\Services\Domain\BalanceServiceInterface;
use Tokenly\Wp\Interfaces\Repositories\BalanceRepositoryInterface;
use Tokenly\Wp\Interfaces\Collections\BalanceCollectionInterface;

/**
 * Manages the balances
 */
class BalanceService extends DomainService implements BalanceServiceInterface {
	protected $balance_cache = array();
	protected $balance_repository;

	public function __construct(
		BalanceRepositoryInterface $balance_repository
	) {
		$this->balance_repository = $balance_repository;
	}

	/**
	 * Retrieves balances associated with the specified oauth token
	 * @param string $oauth_token OAuth token
	 * @param array $params Search parameters
	 * @return BalanceCollectionInterface
	 */
	public function index( string $oauth_token, array $params = array() ) {
		$balances;
		if ( isset( $this->balances_cache[ $oauth_token ] ) ) {
			$balances = $this->balances_cache[ $oauth_token ];
		} else {
			$balances = $this->balance_repository->index( $oauth_token );
			$this->balances_cache[ $oauth_token ] = $balances;
		}
		$balances = $this->index_after( $balances, $params );
		return $balances;
	}
}
