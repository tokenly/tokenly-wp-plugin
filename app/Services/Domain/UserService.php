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
	 * Retrieves a collection of users
	 * @param array $params Search parameters
	 * @return UserCollectionInterface
	 */
	protected function _index( array $params = array() ) {
		$users = $this->user_repository->index( $params );
		return $users;
	}

	/**
	 * Retrieves a single user
	 * @param array $params Search params
	 * @return UserInterface
	 */
	protected function _show( array $params = array() ) {
		if ( isset( $params['id'] ) && $params['id'] == 'me' ) {
			$params['id'] = get_current_user_id();
		}
		$user = $this->user_repository->show( $params );
		return $user;
	}

	/**
	 * Generates a new WordPress user using OAuth user data
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
