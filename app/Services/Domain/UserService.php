<?php

namespace Tokenly\Wp\Services\Domain;

use Tokenly\Wp\Interfaces\Services\Domain\AddressServiceInterface;
use Tokenly\Wp\Interfaces\Services\Domain\BalanceServiceInterface;
use Tokenly\Wp\Interfaces\Services\Domain\OauthUserServiceInterface;
use Tokenly\Wp\Interfaces\Services\Domain\UserServiceInterface;
use Tokenly\Wp\Interfaces\Repositories\General\UserMetaRepositoryInterface;
use Tokenly\Wp\Interfaces\Repositories\UserRepositoryInterface;
use Tokenly\Wp\Interfaces\Collections\UserCollectionInterface;
use Tokenly\Wp\Interfaces\Models\OauthUserInterface;

/**
 * User related functions
 */
class UserService implements UserServiceInterface {
	protected $address_service;
	protected $balance_service;
	protected $oauth_user_service;
	protected $user_repository;
	protected $user_meta_repository;

	public function __construct(
		AddressServiceInterface $address_service,
		BalanceServiceInterface $balance_service,
		OauthUserServiceInterface $oauth_user_service,
		UserRepositoryInterface $user_repository,
		UserMetaRepositoryInterface $user_meta_repository
	) {
		$this->address_service = $address_service;
		$this->balance_service = $balance_service;
		$this->oauth_user_service = $oauth_user_service;
		$this->user_repository = $user_repository;
		$this->user_meta_repository = $user_meta_repository;
	}
	
	/**
	 * Registers the service
	 * @return void
	 */
	public function register() {
		add_filter( 'user_row_actions', array( $this, 'add_view_inventory_user_action' ), 10, 2 ) ;
	}

	/**
	 * Adds an inventory link to WordPress admin user list
	 * @param array $actions Current actions
	 * @param \WP_user $user Current user
	 * @return array $actions Modified actions
	 */
	public function add_view_inventory_user_action( $actions, $user ) {
		$user_id = $user->ID;
		$user = $this->user_repository->show( array(
			'id' => $user_id,
		) );
		if ( $user && $user->can_connect() ) {
			$actions['token_inventory'] = "<a href='/tokenpass-user/{$user_id}' >Token inventory</a>";
		}
		return $actions;
	}

	/**
	 * Gets all addresses
	 * @param array $params Address search parameters
	 * @return AddressCollectionInterface Found addresses
	 */
	public function get_addresses( int $id, array $params = array() ) {
		$oauth_user = $this->get_oauth_user( $id );
		if ( !$oauth_user ) {
			return;
		}
		$username = $oauth_user->username;
		$params['username'] = $username;
		$addresses = $this->address_service->index( $params );
		return $addresses;
	}

	/**
	 * Gets all balances
	 * @param array $params Balance search parameters
	 * @return BalanceCollectionInterface Found balances
	 */
	public function get_balances( int $id, array $params = array() ) {
		$oauth_user = $this->get_oauth_user( $id );
		if ( !$oauth_user ) {
			return;
		}
		$oauth_token = $this->get_oauth_token( $id );
		if ( !$oauth_token ) {
			return;
		}
		$balance = $this->balance_service->index( $oauth_token, $params );
		return $balance;
	}

	/**
	 * Checks if the user is currently connected to Tokenpass
	 * @return bool
	 */
	public function can_connect( int $user_id ) {
		$can_connect =  $this->user_meta_repository->show( $user_id, 'can_connect' ) ?? false;
		return $can_connect;
	}

	public function connect( int $user_id, OauthUserInterface $oauth_user, string $oauth_token ) {
		$this->user_meta_repository->update( $user_id, array(
			'uuid'        => $oauth_user->id,
			'oauth_token' => $oauth_token,
			'can_connect' => true,
		) );
		$user = get_user_by( 'ID', $user_id );
		if ( !$user ) {
			return;
		}
		$user->add_cap( 'use_tokenpass' );
	}

	/**
	 * Disconnects the user from Tokenpass
	 * @return void
	 */
	public function disconnect( int $id ) {
		$this->user_meta_repository->destroy( $id, ...array( 'uuid', 'oauth_token', 'can_connect' ) );
		$user = get_user_by( 'ID', $id );
		if ( !$user ) {
			return;
		}
		$user->remove_cap( 'use_tokenpass');
	}

	/**
	 * Retrieves oauth user from the API
	 * @return OauthUserInterface
	 */
	public function get_oauth_user( $id ) {
		$oauth_user = $this->oauth_user_service->show( $id );
		return $oauth_user;
	}

	/**
	 * Retrieves oauth token from the options
	 * @return string
	 */
	public function get_oauth_token( int $id ) {
		$oauth_token = $this->user_meta_repository->show( $id, 'oauth_token' );
		return $oauth_token;
	}

	public function index( $params ) {
		$users = $this->user_repository->index( $params );
		if ( isset( $params['suggestions'] ) ) {
			$suggestions = $this->make_suggestions( $users );
			return $suggestions;
		}
		return $users;
	}

	public function show( $params ) {
		$users = $this->index( $params );
		return $users[0] ?? null;
	}

	/**
	 * Generates a new WordPress user using Tokenpass data
	 * @param OauthUserInterface $oauth_user Reference user
	 * @return UserInterface New user
	 */
	public function store( OauthUserInterface $oauth_user ) {
		$username = $oauth_user->username;
		$password = wp_generate_password( 12, false );
		$email = $oauth_user->email ?? null;
		$user = $this->user_repository->store( $username, $password, $email );
		return $user;
	}

	/**
	 * Creates an array of suggestions out of users
	 * (used for real-time search in combobox inputs)
	 * @param UserCollectionInterface $users
	 * @return array Suggestions
	 */
	protected function make_suggestions( UserCollectionInterface $users ) {
		$suggestions = array();
		if ( !empty( $users ) ) {
			foreach ( $users as $user ) {
				$suggestions[] = array(
					'id'   => $user->ID, 
					'name' => $user->nickname,
				);
			}
		}
		return $suggestions;
	}

}
