<?php

/**
 * WP_User decorator
 */

namespace Tokenly\Wp\Models;

use Tokenly\Wp\Interfaces\Services\Domain\UserServiceInterface;
use Tokenly\Wp\Interfaces\Models\UserInterface;
use Tokenly\Wp\Interfaces\Models\OauthUserInterface;
use Tokenly\Wp\Interfaces\Models\CurrentUserInterface;

class User implements UserInterface, CurrentUserInterface {
	protected $_instance;
	protected $oauth_user;
	protected $oauth_token;
	protected $addresses;
	protected $user_service;

	public function __construct(
		\WP_User $user,
		UserServiceInterface $user_service
	) {
		$this->_instance = $user;
		$this->user_service = $user_service;
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
		$addresses = $this->user_service->get_addresses( $this->ID, $params );
		return $addresses;
	}

	/**
	 * Gets all balances
	 * @param array $params Balance search parameters
	 * @return BalanceCollectionInterface Found balances
	 */
	public function get_balances( array $params = array() ) {
		$balances = $this->user_service->get_balances( $this->ID, $params );
		return $balances;
	}

	/**
	 * Checks if the user is currently connected to Tokenpass
	 * @return bool
	 */
	public function can_connect() {
		$can_connect = $this->user_service->can_connect( $this->ID );
		return $can_connect;
	}

	public function connect( OauthUserInterface $oauth_user, string $oauth_token ) {
		$this->user_service->connect( $this->ID, $oauth_user, $oauth_token );
	}

	/**
	 * Disconnects the user from Tokenpass
	 * @return void
	 */
	public function disconnect() {
		$this->user_service->disconnect( $this->ID );
	}

	/**
	 * Retrieves oauth user from the API
	 * @return OauthUserInterface
	 */
	public function get_oauth_user() {
		if ( !isset( $this->oauth_user ) ) {
			$this->oauth_user = $this->user_service->get_oauth_user( $this->ID );
		}
		return $this->oauth_user;
	}

	/**
	 * Retrieves oauth token from the options
	 * @return string
	 */
	public function get_oauth_token() {
		if ( !isset( $this->oauth_token ) ) {
			$this->oauth_token = $this->user_service->get_oauth_token( $this->ID );
		}
		return $this->oauth_token;
	}
	
	public function is_guest() {
		return false;
	}
	
	public function to_array() {
		return array(
			'id'   => $this->ID,
			'name' => $this->user_nicename,
		);
	}
}
