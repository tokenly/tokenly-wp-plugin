<?php

namespace Tokenly\Wp\Models;

use Tokenly\Wp\Models\Model;
use Tokenly\Wp\Interfaces\Collections\TcaRuleCollectionInterface;
use Tokenly\Wp\Interfaces\Models\OauthUserInterface;
use Tokenly\Wp\Interfaces\Services\Domain\AddressServiceInterface;
use Tokenly\Wp\Interfaces\Services\Domain\BalanceServiceInterface;
use Tokenly\Wp\Interfaces\Repositories\CreditTransactionRepositoryInterface;
use Tokenly\Wp\Interfaces\Services\Domain\UserServiceInterface;
use Tokenly\Wp\Interfaces\Collections\BalanceCollectionInterface;
use Tokenly\Wp\Interfaces\Collections\AddressCollectionInterface;
use Tokenly\Wp\Interfaces\Models\CreditGroupInterface;
use Tokenly\Wp\Interfaces\Services\Domain\CreditGroupServiceInterface;
use Tokenly\Wp\Interfaces\Services\Domain\CreditAccountServiceInterface;
use Tokenly\Wp\Interfaces\Factories\Collections\CreditAccountCollectionFactoryInterface;
use Tokenly\Wp\Interfaces\Models\Settings\OauthSettingsInterface;
use Tokenly\TokenpassClient\TokenpassAPIInterface;

class OauthUser extends Model implements OauthUserInterface {
	public $id;
	public $username;
	public $email;
	public $name;
	public $email_is_confirmed;
	public $oauth_token;
	/**
	 * @var AddressCollectionInterface $address Collection of blockchain addresses assigned to this account
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
	);

	public function __construct(
		AddressServiceInterface $address_service,
		BalanceServiceInterface $balance_service,
		CreditGroupServiceInterface $credit_group_service,
		CreditTransactionRepositoryInterface $credit_transaction_repository,
		UserServiceInterface $user_service,
		CreditAccountCollectionFactoryInterface $credit_account_collection_factory,
		CreditAccountServiceInterface $credit_account_service,
		TokenpassAPIInterface $client,
		OauthSettingsInterface $oauth_settings,
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

	public function credit_app_credits( array $parameters = array() ) {
		$this->make_transaction( 'credit', $parameters );
	}

	public function debit_app_credits( array $parameters = array() ) {
		$this->make_transaction( 'debit', $parameters );
	}

	protected function make_transaction( string $type, array $parameters = array() ) {
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
			'with' => array(
				'oauth_user',
			),
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
	 * Loads the address relation
	 * @param string[] $relations Further relations
	 * @return self
	 */
	protected function load_address( array $relations = array() ) {
		$address = $this->address_service->index( array(
			'username' => $this->username,
			'with'     => $relations,
		) );
		$this->address = $address;
		return $this;
	}
	
	/**
	 * Loads the credit account relation
	 * @param string[] $relations Further relations
	 * @return self
	 */
	protected function load_credit_account( array $relations = array() ) {
		$credit_groups = $this->credit_group_service->index();
		$group_uuids = array_map( function( CreditGroupInterface $credit_group ) {
			return $credit_group->uuid;
		}, ( array ) $credit_groups );
		$accounts = array();;
		foreach ( $group_uuids as $group_uuid ) {
			$account = $this->credit_account_service->show( array(
				'group_uuid'   => $group_uuid,
				'account_uuid' => $this->id,
			) );
			if ( !$account ) {
				continue;
			}
			$accounts[ $group_uuid ] = $account;
		}
		$accounts = $this->credit_account_collection_factory->create( $accounts );
		$this->credit_account = $accounts;
		return $this;
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
	 * Checks if the user can pass TCA check with
	 * the specified rules
	 * @param TcaRuleCollectionInterface $rules Rules to use
	 * @return bool
	 */
	public function check_token_access( TcaRuleCollectionInterface $rules ) {
		$username = $this->username;
		$oauth_token = $this->oauth_token;
		if ( !$username || !$oauth_token ) {
			return;
		}
		$rules = $rules->format_rules();
		$can_access = boolval( $this->client->checkTokenAccess( $username, $rules, $oauth_token ) ) ?? false;
		return $can_access;
	}
}
