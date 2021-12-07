<?php

namespace Tokenly\Wp\Models;

use Tokenly\Wp\Models\Model;
use Tokenly\Wp\Interfaces\Collections\TcaRuleCollectionInterface;
use Tokenly\Wp\Interfaces\Models\OauthUserInterface;
use Tokenly\Wp\Interfaces\Services\TcaServiceInterface;
use Tokenly\Wp\Interfaces\Services\Domain\AddressServiceInterface;
use Tokenly\Wp\Interfaces\Services\Domain\BalanceServiceInterface;
use Tokenly\Wp\Interfaces\Repositories\CreditTransactionRepositoryInterface;
use Tokenly\Wp\Interfaces\Services\Domain\UserServiceInterface;

class OauthUser extends Model implements OauthUserInterface {
	public $id;
	public $username;
	public $email;
	public $name;
	public $email_is_confirmed;
	public $oauth_token;
	public $balance;
	public $address;
	protected $tca_service;
	protected $address_service;
	protected $balance_service;
	protected $oauth_user_service;
	protected $credit_transaction_repository;
	protected $fillable = array(
		'id',
		'username',
		'email',
		'name',
		'email_is_confirmed',
		'oauth_token',
		'balances',
		'addresses',
	);

	public function __construct(
		TcaServiceInterface $tca_service,
		AddressServiceInterface $address_service,
		BalanceServiceInterface $balance_service,
		CreditTransactionRepositoryInterface $credit_transaction_repository,
		UserServiceInterface $user_service,
		array $data = array()
	) {
		$this->tca_service = $tca_service;
		$this->address_service = $address_service;
		$this->balance_service = $balance_service;
		$this->user_service = $user_service;
		$this->credit_transaction_repository = $credit_transaction_repository;
		parent::__construct( $data );
	}

	/**
	 * Check if the user is allowed to proceed with login
	 * @param array $tokenpass_user
	 * @return bool
	 */
	public function can_social_login() {
		$email = $this->email ?? null;
		$email_is_confirmed = $this->email_is_confirmed ?? null;
		if ( !$email || $email_is_confirmed == false ) {
			return false;	
		}
		return true;
	}

	/**
	 * Checks if the user can pass TCA with the specified rules
	 * @param TcaRuleCollectionInterface $rules TCA rules
	 * @return bool
	 */
	public function check_token_access( TcaRuleCollectionInterface $rules ) {
		$can_access = $this->tca_service->check_token_access_user( $this, $rules );
		return $can_access;
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
		if ( isset( $parameters['source'] ) ) {
			$parameters['source'] = $this->get_transaction_source( $parameters['source'] );
		}
		$transactions = $this->credit_transaction_repository->store( $parameters );
		return $transactions;
	}

	protected function get_transaction_source( string $source ) {
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
		return $user->oauth_user;
	}

	/**
	 * Retrieves the collection of user addresses
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
	 * Retrieves the collection of user balances
	 * @param string[] $relations Further relations
	 * @return self
	 */
	protected function load_balance( array $relations = array() ) {
		$balance = $this->balance_service->index( array(
			'oauth_token' => $this->oauth_token,
			'with'        => $relations,
		) );
		$this->balance = $balance;
		return $this;
	}
}
