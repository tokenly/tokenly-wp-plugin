<?php

namespace Tokenly\Wp\Repositories;

use Tokenly\TokenpassClient\TokenpassAPIInterface;
use Tokenly\Wp\Interfaces\Repositories\CreditAccountRepositoryInterface;
use Tokenly\Wp\Interfaces\Models\CreditAccountInterface;
use Tokenly\Wp\Interfaces\Collections\CreditAccountCollectionInterface;
use Tokenly\Wp\Interfaces\Factories\Models\CreditAccountFactoryInterface;
use Tokenly\Wp\Interfaces\Factories\Collections\CreditAccountCollectionFactoryInterface;
use Tokenly\Wp\Interfaces\Factories\Models\CreditAccountHistoryFactoryInterface;


class CreditAccountRepository implements CreditAccountRepositoryInterface {
	protected $client;
	protected $credit_account_factory;
	protected $credit_account_collection_factory;
	protected $credit_account_history_factory;
	
	public function __construct(
		TokenpassAPIInterface $client,
		CreditAccountFactoryInterface $credit_account_factory,
		CreditAccountCollectionFactoryInterface $credit_account_collection_factory,
		CreditAccountHistoryFactoryInterface $credit_account_history_factory
	) {
		$this->client = $client;
		$this->credit_account_factory = $credit_account_factory;
		$this->credit_account_collection_factory = $credit_account_collection_factory;
		$this->credit_account_history_factory = $credit_account_history_factory;
	}

	/**
	 * Retrieves a collection of credit groups
     * @param array $params Search parameters
	 * @return CreditAccountCollectionInterface Credit groups found
	 */
	public function index( array $params = array() ) {
		if ( !isset( $params['group_uuid'] ) ) {
			return;
		}
		$group_uuid = $params['group_uuid'];
		$accounts = $this->client->listAppCreditAccounts( $group_uuid );
		if( !$accounts ){
			return;
		}
		$accounts = $this->credit_account_collection_factory->create( $accounts );
		return $accounts;
	}

	/**
	 * Retrieves a single credit account
	 * @param array $params Search parameters
	 * @return CreditAccountInterface Credit group found
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
		$account = $this->credit_account_factory->create( $account );
		return $account;
	}
	
	/**
	 * Retrieves history for the credit account
	 * @param array $params Search parameters
	 * @return CreditAccountHistoryInterface Credit group found
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
		$history = $this->credit_account_history_factory->create( $history );
		return $history;
	}
	
	/**
	 * Creates a new credit account
	 * @param array New credit account data
	 * @return CreditAccountInterface
	 */
	public function store( array $params = array() ) {
		if (
			!isset( $params['name'] ) ||
			!isset( $params['group_uuid'] )
		) {
			return;
		}
		$group_uuid = $params['group_uuid'];
		$name = $params['name'];
		$account = $this->client->newAppCreditAccount( $group_uuid, $name );
		if( !$account ){
			return;
		}
		$account = $this->credit_account_factory->create( $account );
		return $account;
	}
}
