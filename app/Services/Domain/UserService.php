<?php

namespace Tokenly\Wp\Services\Domain;

use Tokenly\Wp\Services\Domain\DomainService;
use Tokenly\Wp\Interfaces\Services\Domain\UserServiceInterface;
use Tokenly\Wp\Interfaces\Repositories\General\UserMetaRepositoryInterface;
use Tokenly\Wp\Interfaces\Repositories\UserRepositoryInterface;
use Tokenly\Wp\Interfaces\Collections\UserCollectionInterface;
use Tokenly\Wp\Interfaces\Models\OauthUserInterface;

/**
 * Manages the users
 */
class UserService extends DomainService implements UserServiceInterface {
	protected $user_repository;
	protected $namespace;

	public function __construct(
		UserRepositoryInterface $user_repository,
		string $namespace
	) {
		$this->user_repository = $user_repository;
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
	 * Gets a collection of users
	 * @param array $params Search parameters
	 * @return UserCollectionInterface Users found
	 */
	public function index( array $params = array() ) {
		return $this->handle_method( __FUNCTION__, func_get_args() );
	}

	/**
	 * Gets a single user
	 * @param array $params Search parameters
	 * @return UserInterface User found
	 */
	public function show( array $params = array() ) {
		return $this->handle_method( __FUNCTION__, func_get_args() );
	}

	/**
	 * Gets the current user
	 * @param array $params Additional parameters
	 * @return UserInterface Current user
	 */
	public function show_current( array $params = array() ) {
		$id = get_current_user_id();
		if ( $id == 0 ) {
			return;
		}
		$params['id'] = $id;
		$user = $this->show( $params );
		return $user;
	}

	/**
	 * Makes a new WordPress user using OAuth user data
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
	 * Implementation of the "index" method. Will only
	 * run if no cached instance was found.
	 * @param array $params Search parameters
	 * @return UserCollectionInterface
	 */
	protected function index_cacheable( array $params = array() ) {
		$users = $this->user_repository->index( $params );
		return $users;
	}

	/**
	 * Implementation of the "show" method. Will only
	 * run if no cached instance was found.
	 * @param array $params Search parameters
	 * @return UserInterface
	 */
	protected function show_cacheable( array $params = array() ) {
		if ( isset( $params['id'] ) && $params['id'] == 'me' ) {
			unset( $params['id'] );
			$user = $this->show_current( $params );
		} else {
			$user = $this->user_repository->show( $params );
		}
		return $user;
	}

	/**
	 * Adds an inventory link to WordPress admin user list
	 * @param array $actions Current actions
	 * @param \WP_user $user Current user
	 * @return array $actions Modified actions
	 */
	public function add_view_inventory_user_action( array $actions, \WP_User $user ) {
		$id = $user->ID;
		$user = $this->show( array(
			'id' => $id,
		) );
		if ( $user && $user->can_connect() ) {
			$token_balance_url = admin_url( "admin.php?page={$this->namespace}-user-token-balance-index&id={$id}" );
			$credit_balance_url = admin_url( "admin.php?page={$this->namespace}-user-credit-balance-index&id={$id}" );
			$actions[ "{$this->namespace }_token_balance" ] = "<a href='{$token_balance_url}'>Token Inventory</a>";
			$actions[ "{$this->namespace }_credit_balance" ] = "<a href='{$credit_balance_url}'>Credit Inventory</a>";
		}
		return $actions;
	}
}
