<?php

namespace Tokenly\Wp\Services\Domain;

use Tokenly\Wp\Services\Domain\DomainService;
use Tokenly\Wp\Interfaces\Services\Domain\AddressServiceInterface;
use Tokenly\Wp\Interfaces\Services\Domain\BalanceServiceInterface;
use Tokenly\Wp\Interfaces\Services\Domain\OauthUserServiceInterface;
use Tokenly\Wp\Interfaces\Services\Domain\UserServiceInterface;
use Tokenly\Wp\Interfaces\Repositories\General\UserMetaRepositoryInterface;
use Tokenly\Wp\Interfaces\Repositories\UserRepositoryInterface;
use Tokenly\Wp\Interfaces\Collections\UserCollectionInterface;
use Tokenly\Wp\Interfaces\Models\OauthUserInterface;

/**
 * Manages the users
 */
class UserService extends DomainService implements UserServiceInterface {
	protected $address_service;
	protected $balance_service;
	protected $oauth_user_service;
	protected $user_repository;
	protected $user_meta_repository;
	protected $namespace;

	public function __construct(
		AddressServiceInterface $address_service,
		BalanceServiceInterface $balance_service,
		OauthUserServiceInterface $oauth_user_service,
		UserRepositoryInterface $user_repository,
		UserMetaRepositoryInterface $user_meta_repository,
		string $namespace
	) {
		$this->address_service = $address_service;
		$this->balance_service = $balance_service;
		$this->oauth_user_service = $oauth_user_service;
		$this->user_repository = $user_repository;
		$this->user_meta_repository = $user_meta_repository;
		$this->namespace = $namespace;
	}
	
	/**
	 * Registers the service
	 * @return void
	 */
	public function register() {
		add_filter( 'user_row_actions', array( $this, 'add_view_inventory_user_action' ), 10, 2 ) ;
	}

	/**
	 * Gets a list of users
	 * @param array $params Search parameters
	 * @return UserCollectionInterface
	 */
	public function index( array $params ) {
		$users = $this->user_repository->index( $params );
		if ( isset( $params['suggestions'] ) ) {
			$suggestions = $this->make_suggestions( $users );
			return $suggestions;
		}
		if ( isset( $params['with'] ) ) {
			$users = $users->load( $params['with'] );
		}
		return $users;
	}

	public function show( array $params ) {
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

	/**
	 * Adds an inventory link to WordPress admin user list
	 * @param array $actions Current actions
	 * @param \WP_user $user Current user
	 * @return array $actions Modified actions
	 */
	public function add_view_inventory_user_action( array $actions, \WP_User $user ) {
		$user_id = $user->ID;
		$user = $this->show( array(
			'id' => $user_id,
		) );
		if ( $user && $user->can_connect() ) {
			$actions["{$this->namespace}_inventory"] = "<a href='/{$this->namespace}/user/{$user_id}'>Token inventory</a>";
		}
		return $actions;
	}

}
