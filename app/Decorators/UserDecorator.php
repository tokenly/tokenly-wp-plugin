<?php

namespace Tokenly\Wp\Decorators;

use Tokenly\Wp\Interfaces\Decorators\UserDecoratorInterface;
use Tokenly\Wp\Interfaces\Repositories\AddressRepositoryInterface;
use Tokenly\Wp\Interfaces\Repositories\BalanceRepositoryInterface;
use Tokenly\Wp\Interfaces\Models\AddressInterface;

class UserDecorator implements UserDecoratorInterface {
	public $tokenpass_user;
	protected $_instance;
	protected $address_repository;
	protected $balance_repository;

	public function __construct(
		\WP_User $user,
		$tokenpass_user = null,
		AddressRepositoryInterface $address_repository,
		BalanceRepositoryInterface $balance_repository
	) {
		$this->_instance = $user;
		$this->tokenpass_user = $tokenpass_user;
		$this->address_repository = $address_repository;
		$this->balance_repository = $balance_repository;
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
	 * Gets all Tokenpass addresses
	 * @return AddressInterface[] Found addresses
	 */
	public function get_addresses() {
		$username = $this->tokenpass_user['username'] ?? null;
		if ( !$username ) {
			return;
		}
		$addresses = $this->address_repository->index( array(
			'username' => $username,
		) );
		return $addresses;
	}

	/**
	 * Gets all Tokenpass balances
	 * @return BalanceInterface[] Found balances
	 */
	public function get_balances() {
		$balance = $this->balance_repository->index( $this->ID );
		return $balance;
	}
}
