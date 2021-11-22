<?php

namespace Tokenly\Wp\Services;

use Tokenly\Wp\Interfaces\Services\UserServiceInterface;
use Tokenly\Wp\Interfaces\Repositories\UserRepositoryInterface;

/**
 * User related functions
 */
class UserService implements UserServiceInterface {
	protected $user_repository;

	public function __construct(
		UserRepositoryInterface $user_repository
	) {
		$this->user_repository = $user_repository;
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
}
