<?php

/**
 * WP_User decorator
 */

namespace Tokenly\Wp\Models;

use Tokenly\Wp\Interfaces\Repositories\AddressRepositoryInterface;
use Tokenly\Wp\Interfaces\Repositories\BalanceRepositoryInterface;
use Tokenly\Wp\Interfaces\Repositories\OauthUserRepositoryInterface;
use Tokenly\Wp\Interfaces\Repositories\General\UserMetaRepositoryInterface;
use Tokenly\Wp\Interfaces\Models\UserInterface;
use Tokenly\Wp\Interfaces\Models\OauthUserInterface;
use Tokenly\Wp\Interfaces\Collection\BalanceCollectionInterface;
use Tokenly\Wp\Interfaces\Collection\AddressCollectionInterface;
use Tokenly\Wp\Interfaces\Models\CurrentUserInterface;

class User implements UserInterface, CurrentUserInterface {
	protected $_instance;
	protected $oauth_user;
	protected $oauth_token;
	protected $address_repository;
	protected $balance_repository;
	protected $oauth_user_repository;
	protected $user_meta_repository;

	public function __construct(
		\WP_User $user,
		AddressRepositoryInterface $address_repository,
		BalanceRepositoryInterface $balance_repository,
		OauthUserRepositoryInterface $oauth_user_repository,
		UserMetaRepositoryInterface $user_meta_repository
	) {
		$this->_instance = $user;
		$this->address_repository = $address_repository;
		$this->balance_repository = $balance_repository;
		$this->oauth_user_repository = $oauth_user_repository;
		$this->user_meta_repository = $user_meta_repository;
	}

	public function __call( $method, $args ) {
		return call_user_func_array( array( $this->_instance, $method ), $args );
	}

	public function __get( $key ) {
		return $this->_instance->$key;
	}

	public function __set( $key, $val ) {
		return $this->_instance->$key = $val;
	}

	/**
	 * Gets all addresses
	 * @param array $params Address search parameters
	 * @return AddressCollectionInterface Found addresses
	 */
	public function get_addresses( array $params = array() ) {
		$oauth_user = $this->get_oauth_user();
		if ( !$oauth_user ) {
			return;
		}
		$username = $oauth_user->username;
		$params['username'] = $username;
		$addresses = $this->address_repository->index( $params );
		return $addresses;
	}

	/**
	 * Gets all balances
	 * @param array $params Balance search parameters
	 * @return BalanceCollectionInterface Found balances
	 */
	public function get_balances( array $params = array() ) {
		$oauth_token = $this->get_oauth_token();
		$balance = $this->balance_repository->index( $oauth_token, $params );
		return $balance;
	}

	/**
	 * Checks if the user is currently connected to Tokenpass
	 * @return bool
	 */
	public function is_connected() {
		$oauth_user = $this->get_oauth_user();
		if ( $oauth_user ) {
			return true;
		} else {
			return false;
		}
	}

	public function connect( OauthUserInterface $oauth_user, string $access_token ) {
		$this->user_meta_repository->update( $this->ID, array(
			'uuid'        => $oauth_user->id,
			'oauth_token' => $access_token,
		) );
		$this->add_cap( 'use_tokenpass' );
	}

	/**
	 * Disconnects the user from Tokenpass
	 * @return void
	 */
	public function disconnect() {
		$this->user_meta_repository->destroy( $this->ID, ...array( 'uuid', 'oauth_token' ) );
		$this->remove_cap( 'use_tokenpass');
	}

	/**
	 * Retrieves oauth token from the options
	 * @return string
	 */
	protected function get_oauth_token() {
		if ( !$this->oauth_token ) {
			$this->oauth_token = $this->user_meta_repository->show( $this->ID, 'oauth_token' );
		}
		return $this->oauth_token;	
	}

	/**
	 * Retrieves oauth user from the API
	 * @return OauthUserInterface
	 */
	public function get_oauth_user() {
		if ( !isset( $this->oauth_user ) ) {
			$oauth_user = $this->oauth_user_repository->show( $this->ID );
			$this->oauth_user = $oauth_user;
		}
		return $this->oauth_user;
	}
}
