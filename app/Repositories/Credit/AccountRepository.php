<?php

namespace Tokenly\Wp\Repositories\Credit;

use Tokenly\Wp\Repositories\Repository;
use Tokenly\Wp\Interfaces\Repositories\Credit\AccountRepositoryInterface;

use Tokenly\Wp\Collections\Credit\AccountCollection;
use Tokenly\Wp\Models\Credit\Account;
use Tokenly\Wp\Models\Credit\AccountHistory;
use Tokenly\Wp\Interfaces\Models\Credit\AccountInterface;
use Tokenly\Wp\Interfaces\Models\Credit\AccountHistoryInterface;
use Tokenly\Wp\Interfaces\Collections\Credit\AccountCollectionInterface;
use Tokenly\TokenpassClient\TokenpassAPIInterface;

class AccountRepository extends Repository implements AccountRepositoryInterface {
	protected TokenpassAPIInterface $client;
	
	public function __construct(
		TokenpassAPIInterface $client
	) {
		$this->client = $client;
	}

	/**
	 * Gets a collection of accounts
	 * @param array $params Search parameters
	 * @return AccountCollectionInterface Accounts found
	 */
	public function index( array $params = array() ): AccountCollectionInterface {
		return $this->handle_method( __FUNCTION__, func_get_args() );
	}

	/**
	 * Gets a single account
	 * @param array $params Search parameters
	 * @return AccountInterface|null Account found
	 */
	public function show( array $params = array() ): ?AccountInterface {
		return $this->handle_method( __FUNCTION__, func_get_args() );
	}

	/**
	 * Retrieves history for the account
	 * @param array $params Search parameters
	 * @return AccountHistoryInterface Group found
	 */
	public function show_history( array $params = array() ): AccountHistoryInterface {
		if (
			!isset( $params['group_uuid'] ) ||
			!isset( $params['account_uuid'] )
		) {
			return null;
		}
		$group_uuid = $params['group_uuid'];
		$account_uuid = $params['account_uuid'];
		$history = $this->client->getAppCreditAccountHistory( $group_uuid, $account_uuid );
		if( !$history ){
			return null;
		}
		$history = ( new AccountHistory() )->from_array( $history );
		return $history;
	}

	/**
	 * Creates a new account for the specified user
	 * @param array $params New account data
	 * @return AccountInterface|null New account
	 */
	public function store( array $params = array() ): ?AccountInterface {
		if (
			!isset( $params['account_uuid'] ) ||
			!isset( $params['group_uuid'] )
		) {
			return null;
		}
		$group_uuid = $params['group_uuid'];
		$name = $params['account_uuid'];
		$account = $this->client->newAppCreditAccount( $group_uuid, $name );
		if( !$account ){
			return null;
		}
		$account = ( new Account() )->from_array( $account );
		return $account;
	}

	/**
	 * Implementation of the "index" method. Will only
	 * run if no cached instance was found.
	 * @param array $params Search parameters
	 * @return AccountCollectionInterface Accounts found
	 */
	protected function index_cacheable( array $params = array() ): AccountCollectionInterface {
		$accounts = array();
		if ( isset( $params['group_uuid'] ) ) {
			$group_uuid = $params['group_uuid'];
			$accounts_found = $this->client->listAppCreditAccounts( $group_uuid );
			if ( $accounts_found && is_array( $accounts_found ) ) {
				$accounts = $accounts_found;
			}
		}
		$accounts = ( new AccountCollection() )->from_array( $accounts );
		return $accounts;
	}

	/**
	 * Implementation of the "show" method. Will only
	 * run if no cached instance was found.
	 * @param array $params Search parameters
	 * @return AccountInterface|null Account found
	 */
	protected function show_cacheable( array $params = array() ): ?AccountInterface {
		if (
			!isset( $params['group_uuid'] ) ||
			!isset( $params['account_uuid'] )
		) {
			return null;
		}
		$group_uuid = $params['group_uuid'];
		$account_uuid = $params['account_uuid'];
		$account = $this->client->getAppCreditAccount( $group_uuid, $account_uuid );
		if( !$account ){
			return null;
		}
		$account = ( new Account() )->from_array( $account );
		return $account;
	}
}
