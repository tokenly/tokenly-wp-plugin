<?php

namespace Tokenly\Wp\Repositories;

use Tokenly\Wp\Repositories\Repository;
use Tokenly\Wp\Interfaces\Repositories\OauthUserRepositoryInterface;

use Tokenly\Wp\Models\OauthUser;
use Tokenly\Wp\Collections\Credit\AccountCollection as CreditAccountCollection;
use Tokenly\Wp\Collections\Token\BalanceCollection as TokenBalanceCollection;
use Tokenly\Wp\Models\Token\Balance as TokenBalance;
use Tokenly\Wp\Interfaces\Collections\Credit\AccountCollectionInterface as CreditAccountCollectionInterface;
use Tokenly\Wp\Interfaces\Collections\Token\AddressCollectionInterface as TokenAddressCollectionInterface;
use Tokenly\Wp\Interfaces\Collections\Token\BalanceCollectionInterface as TokenBalanceCollectionInterface;
use Tokenly\Wp\Interfaces\Models\Credit\AccountInterface as CreditAccountInterface;
use Tokenly\Wp\Interfaces\Models\Token\BalanceInterface as TokenBalanceInterface;
use Tokenly\Wp\Interfaces\Models\OauthUserInterface;
use Tokenly\Wp\Interfaces\Repositories\Credit\AccountRepositoryInterface as CreditAccountRepositoryInterface;
use Tokenly\Wp\Interfaces\Repositories\Credit\GroupRepositoryInterface as CreditGroupRepositoryInterface;
use Tokenly\Wp\Interfaces\Repositories\Token\BalanceRepositoryInterface as TokenBalanceRepositoryInterface;
use Tokenly\Wp\Interfaces\Repositories\General\UserMetaRepositoryInterface;
use Tokenly\Wp\Interfaces\Repositories\Token\AddressRepositoryInterface as TokenAddressRepositoryInterface;
use Tokenly\TokenpassClient\TokenpassAPIInterface;

class OauthUserRepository extends Repository implements OauthUserRepositoryInterface {
	protected TokenBalanceRepositoryInterface $token_balance_repository;
	protected UserMetaRepositoryInterface $user_meta_repository;
	protected CreditAccountRepositoryInterface $credit_account_repository;
	protected CreditGroupRepositoryInterface $credit_group_repository;
	protected TokenAddressRepositoryInterface $address_repository;
	protected TokenpassAPIInterface $client;
	
	public function __construct(
		UserMetaRepositoryInterface $user_meta_repository,
		CreditAccountRepositoryInterface $credit_account_repository,
		CreditGroupRepositoryInterface $credit_group_repository,
		TokenBalanceRepositoryInterface $token_balance_repository,
		TokenAddressRepositoryInterface $address_repository,
		TokenpassAPIInterface $client
	) {
		$this->client = $client;
		$this->token_balance_repository = $token_balance_repository;
		$this->user_meta_repository = $user_meta_repository;
		$this->credit_account_repository = $credit_account_repository;
		$this->credit_group_repository = $credit_group_repository;
		$this->address_repository = $address_repository;
	}

	/**
	 * Retrieves a single OAuth user object
	 * @param array $params Search parameters
	 * @return OauthUserInterface|null
	 */
	public function show( array $params = array() ): ?OauthUserInterface {
		return $this->handle_method( __FUNCTION__, func_get_args() );
	}


	/**
	 * Gets a collection credit of balance
	 * @param UserInterface $user Bound user
	 * @param \WP_REST_Request $request Request data
	 * @return TokenAccountCollectionInterface
	 */
	public function credit_balance_index( OauthUserInterface $oauth_user ): TokenAccountCollectionInterface {
		$this->load( $oauth_user, array( 'credit_account' ) );
		$account = new TokenAccountCollection();
		if ( $oauth_user->get_credit_account() ) {
			$account = clone $oauth_user->get_credit_account();
		}
		return $account;
	}

	/**
	 * Gets a single credit balance
	 * @param OauthUserInterface $oauth_user Target OAuth User
	 * @param \WP_REST_Request $request Request data
	 * @return CreditAccountInterface|null
	 */
	public function credit_balance_show( OauthUserInterface $oauth_user, string $group_id ): ?CreditAccountInterface {
		$account = $this->credit_account_repository->show( array(
			'group_uuid'   => $group_id,
			'account_uuid' => $oauth_user->get_id(),
		) );
		return $account;
	}

	/**
	 * Gets a collection of token balance
	 * @param OauthUserInterface $oauth_user Target OAuth User
	 * @param \WP_REST_Request $request Request data
	 * @return TokenBalanceCollectionInterface
	 */
	public function token_balance_index( OauthUserInterface $oauth_user, \WP_REST_Request $request ): TokenBalanceCollectionInterface {
		$this->load( $oauth_user, array( 'balance.meta' ) );
		if ( !$oauth_user->get_balance() ) {
			return new TokenBalanceCollection( array() );
		}
		$balance = clone $oauth_user->get_balance();
		return $balance;
	}

	/**
	 * Gets a single balance
	 * @param OauthUserInterface $oauth_user Target OAuth User
	 * @param \WP_REST_Request $request Request data
	 * @return TokenBalanceInterface|null
	 */
	public function token_balance_show( OauthUserInterface $oauth_user, string $asset ): ?TokenBalanceInterface {
		$this->load( $oauth_user, array( 'balance' ) );
		$balance = clone $oauth_user->get_balance();
		$balance->key_by_asset_name();
		if ( isset( $balance[ $asset ] ) ) {
			$balance = $balance[ $asset ];
			return $balance;
		}
		return null;
	}

	/**
	 * Gets a collection of addresses
	 * @param OauthUserInterface $oauth_user Target OAuth User
	 * @param bool $registered Get only registered addresses
	 * @return TokenAddressCollectionInterface
	 */
	public function token_address_index( OauthUserInterface $oauth_user, bool $registered = false ): TokenAddressCollectionInterface {
		$this->load( $oauth_user, array( 'address' ) );
		$address = clone $oauth_user->get_address();
		if ( $registered === true ) {
			$address->filter_registered();
		}
		return $address;
	}

	/**
	 * Implementation of the "show" method. Will only
	 * run if no cached instance was found.
	 * @param array $params Search parameters
	 * @return OauthUserInterface|null
	 */
	protected function show_cacheable( array $params = array() ): ?OauthUserInterface {
		$oauth_token;
		if ( isset( $params['id'] ) ) {
			$user_id = $params['id'];
			$oauth_token = $this->user_meta_repository->show( $user_id, 'oauth_token' );
			$params['oauth_token'] = $oauth_token;
		}
		$oauth_user = null;
		if ( isset( $params['oauth_token'] ) ) {
			$oauth_user = $this->show_by_oauth_token( $params['oauth_token'] );
		} elseif ( isset( $params['address'] ) ) {
			$oauth_user = $this->show_by_address( $params['address'] );
		}
		if ( !$oauth_user ) {
			return null;
		}
		$oauth_user = ( new OauthUser() )->from_array( $oauth_user );
		if ( !$oauth_user ) {
			return null;
		}
		return $oauth_user;
	}

	/**
	 * Retrieves an OAuth user by address
	 * @param string $address Address to use for search
	 * @return array|null
	 */
	protected function show_by_address( string $address ): ?array {
		$oauth_user = $this->client->lookupUserByAddress( $address );
		if ( !$oauth_user || !is_array( $oauth_user ) ) {
			return null;
		}
		$oauth_user = $oauth_user['result'];
		unset( $oauth_user['address'] );
		unset( $oauth_user['blockchain'] );
		return $oauth_user;
	}

	/**
	 * Retrieves an OAuth user by OAuth token
	 * @param string $oauth_token OAuth token to use for search
	 * @return array|null
	 */
	protected function show_by_oauth_token( string $oauth_token ): ?array {
		$oauth_user = $this->client->getUserByToken( $oauth_token );
		if ( !is_array( $oauth_user ) ) {
			return null;
		}
		$oauth_user['oauth_token'] = $oauth_token;
		return $oauth_user;
	}

	/**
	 * Loads the balance relation
	 * @param OauthUserInterface $oauth_user Target OAuth User
	 * @param string[] $relations Further relations
	 * @return TokenBalanceCollectionInterface
	 */
	protected function load_balance( OauthUserInterface $oauth_user, array $relations = array() ): TokenBalanceCollectionInterface {
		$balance = $this->token_balance_repository->index( array(
			'oauth_token'  => $oauth_user->get_oauth_token(),
			'with'         => $relations,
		) );
		return $balance;
	}

	/**
	 * Loads the address relation
	 * @param OauthUserInterface $oauth_user Target OAuth User
	 * @param string[] $relations Further relations
	 * @return TokenAddressCollectionInterface
	 */
	protected function load_address( OauthUserInterface $oauth_user, array $relations = array() ): TokenAddressCollectionInterface {
		$address = $this->address_repository->index( array(
			'username'    => $oauth_user->get_username(),
			'oauth_token' => $oauth_user->get_oauth_token(),
			'with'        => $relations,
		) );
		return $address;
	}
	
	/**
	 * Loads the credit_account relation
	 * @param OauthUserInterface $oauth_user Target OAuth User
	 * @param string[] $relations Further relations
	 * @return CreditAccountCollectionInterface
	 */
	protected function load_credit_account( OauthUserInterface $oauth_user, array $relations = array() ): CreditAccountCollectionInterface {
		$groups = $this->credit_group_repository->index();
		$groups = clone $groups->key_by_field( 'uuid' );
		$accounts = new CreditAccountCollection();
		foreach ( ( array ) $groups as $group ) {
			$account = $this->credit_account_repository->show( array(
				'group_uuid'   => $group->get_uuid(),
				'account_uuid' => $oauth_user->get_id(),
			) );
			if ( !$account ) {
				continue;
			}
			$account->set_group_id( $group->get_uuid() );
			$account->set_group( $group );
			$accounts[ $group->get_uuid() ] = $account;
		}
		return $accounts;
	}
}
