<?php

/**
 * WP_User decorator
 */

namespace Tokenly\Wp\Models;

use Tokenly\Wp\Models\Model;
use Tokenly\Wp\Interfaces\Services\Domain\UserServiceInterface;
use Tokenly\Wp\Interfaces\Models\UserInterface;
use Tokenly\Wp\Interfaces\Models\OauthUserInterface;
use Tokenly\Wp\Interfaces\Models\CurrentUserInterface;
use Tokenly\Wp\Interfaces\Collections\TcaRuleCollectionInterface;

class User extends Model implements UserInterface, CurrentUserInterface {
	protected $user;
	public $oauth_user;
	protected $user_service;
	protected $fillable = array(
		'user',
		'oauth_user',
	);

	public function __construct(
		UserServiceInterface $user_service,
		array $data = array()
	) {
		$this->user = $user;
		$this->user_service = $user_service;
	}

	public function __call( $method, $args ) {
		return call_user_func_array( array( $this->user, $method ), $args );
	}

	public function __get( $key ) {
		return $this->user->$key;
	}

	public function __set( $key, $val ) {
		return $this->user->$key = $val;
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

	public function check_token_access( TcaRuleCollectionInterface $rules ) {
		$oauth_user = $this->get_oauth_user();
		if ( !$oauth_user ) {
			return false;
		}
		$can_access = $this->oauth_user->check_token_access( $rules );
		return $can_access;
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
