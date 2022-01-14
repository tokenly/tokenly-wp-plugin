<?php

namespace Tokenly\Wp\Repositories\Credit;

use Tokenly\Wp\Interfaces\Repositories\Credit\AccountRepositoryInterface;

use Tokenly\Wp\Interfaces\Models\Credit\AccountInterface;
use Tokenly\Wp\Interfaces\Collections\Credit\AccountCollectionInterface;
use Tokenly\Wp\Interfaces\Factories\Models\Credit\AccountFactoryInterface;
use Tokenly\Wp\Interfaces\Factories\Collections\Credit\AccountCollectionFactoryInterface;
use Tokenly\Wp\Interfaces\Factories\Models\Credit\AccountHistoryFactoryInterface;
use Tokenly\TokenpassClient\TokenpassAPIInterface;

class AccountRepository implements AccountRepositoryInterface {
	protected $client;
	protected $account_factory;
	protected $account_collection_factory;
	protected $account_history_factory;
	
	public function __construct(
		TokenpassAPIInterface $client,
		AccountFactoryInterface $account_factory,
		AccountCollectionFactoryInterface $account_collection_factory,
		AccountHistoryFactoryInterface $account_history_factory
	) {
		$this->client = $client;
		$this->account_factory = $account_factory;
		$this->account_collection_factory = $account_collection_factory;
		$this->account_history_factory = $account_history_factory;
	}

	/**
	 * Gets a collection of accounts
     * @param array $params Search parameters
	 * @return AccountCollectionInterface Accounts found
	 */
	public function index( array $params = array() ) {
		if ( !isset( $params['group_uuid'] ) ) {
			return;
		}
		$group_uuid = $params['group_uuid'];
		$accounts = $this->client->listAppCreditAccounts( $group_uuid );
		if( !$accounts ) {
			$accounts = array();
		}
		$accounts = $this->account_collection_factory->create( $accounts );
		return $accounts;
	}

	/**
	 * Gets a single account
	 * @param array $params Search parameters
	 * @return AccountInterface Account found
	 */
	public function show( array $params = array() ) {
		if (
			!isset( $params['group_uuid'] ) ||
			!isset( $params['account_uuid'] )
		) {
			return;
		}
		$group_uuid = $params['group_uuid'];
		$account_uuid = $params['account_uuid'];
		$account = $this->client->getAppCreditAccount( $group_uuid, $account_uuid );
		if( !$account ){
			return;
		}
		$account = $this->account_factory->create( $account );
		return $account;
	}
	
	/**
	 * Retrieves history for the account
	 * @param array $params Search parameters
	 * @return AccountHistoryInterface Group found
	 */
	public function show_history( array $params = array() ) {
		if (
			!isset( $params['group_uuid'] ) ||
			!isset( $params['account_uuid'] )
		) {
			return;
		}
		$group_uuid = $params['group_uuid'];
		$account_uuid = $params['account_uuid'];
		$history = $this->client->getAppCreditAccountHistory( $group_uuid, $account_uuid );
		if( !$history ){
			return;
		}
		$history = $this->account_history_factory->create( $history );
		return $history;
	}
	
	/**
	 * Creates a new account
	 * @param array New account data
	 * @return AccountInterface New account
	 */
	public function store( array $params = array() ) {
		if (
			!isset( $params['account_uuid'] ) ||
			!isset( $params['group_uuid'] )
		) {
			return;
		}
		$group_uuid = $params['group_uuid'];
		$name = $params['account_uuid'];
		$account = $this->client->newAppCreditAccount( $group_uuid, $name );
		if( !$account ){
			return;
		}
		$account = $this->account_factory->create( $account );
		return $account;
	}
}
