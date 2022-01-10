<?php

namespace Tokenly\Wp\Models;

use Tokenly\Wp\Models\Model;
use Tokenly\Wp\Interfaces\Models\OauthUserInterface;

use Tokenly\Wp\Interfaces\Collections\Token\AddressCollectionInterface;
use Tokenly\Wp\Interfaces\Collections\Token\BalanceCollectionInterface;
use Tokenly\Wp\Interfaces\Collections\Credit\AccountCollectionInterface;
use Tokenly\Wp\Interfaces\Collections\Tca\RuleCollectionInterface;
use Tokenly\Wp\Interfaces\Factories\Collections\Credit\AccountCollectionFactoryInterface;
use Tokenly\Wp\Interfaces\Factories\Models\Tca\RuleCheckResultFactoryInterface;
use Tokenly\Wp\Interfaces\Models\Credit\GroupInterface;
use Tokenly\Wp\Interfaces\Models\Tca\AccessReportInterface;
use Tokenly\Wp\Interfaces\Models\Tca\RuleCheckResultInterface;
use Tokenly\Wp\Interfaces\Models\Settings\OauthSettingsInterface;
use Tokenly\Wp\Interfaces\Repositories\Credit\TransactionRepositoryInterface;
use Tokenly\Wp\Interfaces\Services\Domain\UserServiceInterface;
use Tokenly\Wp\Interfaces\Services\Domain\Credit\GroupServiceInterface;
use Tokenly\Wp\Interfaces\Services\Domain\Credit\AccountServiceInterface;
use Tokenly\Wp\Interfaces\Services\Domain\Token\AddressServiceInterface;
use Tokenly\Wp\Interfaces\Services\Domain\Token\BalanceServiceInterface;
use Tokenly\TokenpassClient\TokenpassAPIInterface;

class OauthUser extends Model implements OauthUserInterface {
	public $id;
	public $username;
	public $email;
	public $name;
	public $email_is_confirmed;
	public $oauth_token;
	public $balance;
	/**
	 * Collection of blockchain addresses assigned to this account
	 * @var AddressCollectionInterface $address
	 */
	public $address;
	public $credit_account;
	protected $address_service;
	protected $balance_service;
	protected $oauth_user_service;
	protected $credit_group_service;
	protected $credit_account_service;
	protected $credit_transaction_repository;
	protected $credit_account_collection_factory;
	protected $oauth_settings;
	protected $client;
	protected $tca_rule_check_result_factory;
	protected $fillable = array(
		'id',
		'username',
		'email',
		'name',
		'email_is_confirmed',
		'oauth_token',
		'balance',
		'address',
		'credit_group',
		'credit_account',
	);

	public function __construct(
		AddressServiceInterface $address_service,
		BalanceServiceInterface $balance_service,
		GroupServiceInterface $credit_group_service,
		TransactionRepositoryInterface $credit_transaction_repository,
		UserServiceInterface $user_service,
		AccountCollectionFactoryInterface $credit_account_collection_factory,
		AccountServiceInterface $credit_account_service,
		TokenpassAPIInterface $client,
		OauthSettingsInterface $oauth_settings,
		RuleCheckResultFactoryInterface $tca_rule_check_result_factory,
		array $data = array()
	) {
		$this->address_service = $address_service;
		$this->balance_service = $balance_service;
		$this->oauth_settings = $oauth_settings;
		$this->user_service = $user_service;
		$this->credit_transaction_repository = $credit_transaction_repository;
		$this->credit_account_collection_factory = $credit_account_collection_factory;
		$this->credit_group_service = $credit_group_service;
		$this->credit_account_service = $credit_account_service;
		$this->client = $client;
		$this->tca_rule_check_result_factory = $tca_rule_check_result_factory;
		parent::__construct( $data );
	}

	/**
	 * Check if the user is allowed to proceed with login
	 * @return bool
	 */
	public function can_social_login() {
		$email = $this->email ?? null;
		$email_is_confirmed = $this->email_is_confirmed ?? false;
		if ( !$email && $this->oauth_settings->allow_no_email == false ) {
			return false;
		}
		if ( $email_is_confirmed == false && $this->oauth_settings->allow_unconfirmed_email == false ) {
			return false;	
		}
		return true;
	}

	/**
	 * Makes a credit transaction (app credits) for the user
	 * @param array $parameters Transaction parameters
	 * @return array
	 */
	public function credit_app_credits( array $parameters = array() ) {
		$transactions = $this->make_transaction( 'credit', $parameters );
		return $transactions;
	}

	/**
	 * Makes a debit transaction (app credits) for the user
	 * @param array $parameters Transaction parameters
	 * @return array
	 */
	public function debit_app_credits( array $parameters = array() ) {
		$transactions = $this->make_transaction( 'debit', $parameters );
		return $transactions;
	}

	/**
	 * Checks if the user can pass TCA check with
	 * the specified rules
	 * @param RuleCollectionInterface $rules Rules to use
	 * @return RuleCheckResultInterface
	 */
	public function check_token_access( RuleCollectionInterface $rules ) {
		if ( !isset( $this->username ) || !isset( $this->oauth_token ) ) {
			return;
		}
		$username = $this->username;
		$oauth_token = $this->oauth_token;
		$rules_formatted = $rules->format_rules();
		$status = boolval( $this->client->checkTokenAccess( $username, $rules_formatted, $oauth_token ) ) ?? false;
		$report = $this->tca_rule_check_result_factory->create( array(
			'hash'   => $rules->to_hash(),
			'status' => $status,
		) );
		return $report;
	}

	/**
	 * Makes a transaction of the specified type
	 * @param string $type Transaction type
	 * @param array $parameters Transaction parameters
	 * @return array
	 */
	protected function make_transaction( string $type, array $parameters = array() ) {
		error_log(d( $parameters ));
		$parameters['type'] = $type;
		$parameters['account'] = $this;
		$group_uuid = $parameters['group_uuid'];
		if ( isset( $parameters['source'] ) ) {
			$source = $parameters['source'];
			$parameters['source'] = $this->get_transaction_source( $source, $group_uuid );
		}
		$this->ensure_credit_account_exists( $group_uuid );
		$transactions = $this->credit_transaction_repository->store( $parameters );
		return $transactions;
	}

	protected function get_transaction_source( string $source, string $group_uuid ) {
		$user = null;
		$user = $this->user_service->show( array(
			'id'   => $source,
			'with' => array( 'oauth_user' ),
		) );
		if ( !$user ) {
			return;
		}
		if ( !isset( $user->oauth_user ) ) {
			return;
		}
		$user->oauth_user->ensure_credit_account_exists( $group_uuid );
		return $user->oauth_user;
	}

	/**
	 * Checks if the user has an existing credit account and if not creates a new one
	 * for the specified credit group
	 * @param string $group_id Index of the token group
	 * @return void
	 */
	protected function ensure_credit_account_exists( string $group_uuid ) {
		$account = $this->credit_account_service->show( array(
			'account_uuid' => $this->id,
			'group_uuid'   => $group_uuid,
		) );
		if( !$account ){
			$account = $this->credit_account_service->store( array(
				'account_uuid' => $this->id,
				'group_uuid'   => $group_uuid,
			) );
		}
		return $this;
	}

	/**
	 * Loads the balance relation
	 * @param string[] $relations Further relations
	 * @return BalanceCollectionInterface
	 */
	protected function load_balance( array $relations = array() ) {
		$balance = $this->balance_service->index( array(
			'oauth_token'  => $this->oauth_token,
			'with'         => $relations,
		) );
		return $balance;
	}

	/**
	 * Loads the address relation
	 * @param string[] $relations Further relations
	 * @return AddressCollectionInterface
	 */
	protected function load_address( array $relations = array() ) {
		$address = $this->address_service->index( array(
			'username' => $this->username,
			'with'     => $relations,
		) );
		return $address;
	}
	
	/**
	 * Loads the credit_account relation
	 * @param string[] $relations Further relations
	 * @return AccountCollectionInterface
	 */
	protected function load_credit_account( array $relations = array() ) {
		$credit_groups = $this->credit_group_service->index();
		$group_uuids = array_map( function( GroupInterface $credit_group ) {
			return $credit_group->uuid;
		}, ( array ) $credit_groups );
		$credit_account = array();;
		foreach ( $group_uuids as $group_uuid ) {
			$account = $this->credit_account_service->show( array(
				'group_uuid'   => $group_uuid,
				'account_uuid' => $this->id,
			) );
			if ( !$account ) {
				continue;
			}
			$credit_account[ $group_uuid ] = $account;
		}
		$credit_account = $this->credit_account_collection_factory->create( $credit_account );
		return $credit_account;
	}
}
