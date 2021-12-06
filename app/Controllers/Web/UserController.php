<?php

namespace Tokenly\Wp\Controllers\Web;

use Tokenly\Wp\Interfaces\Controllers\Web\UserControllerInterface;
use Tokenly\Wp\Interfaces\Services\Domain\UserServiceInterface;
use Tokenly\Wp\Interfaces\Models\CurrentUserInterface;
use Tokenly\Wp\Views\UserView;

/**
 * Serves the public user views
 */
class UserController implements UserControllerInterface {
	protected $user_service;
	protected $user_view;
	protected $current_user;
	protected $namespace;

	public function __construct(
		UserServiceInterface $user_service,
		CurrentUserInterface $current_user,
		UserView $user_view,
		string $namespace
	) {
		$this->user_service = $user_service;
		$this->current_user = $current_user;
		$this->user_view = $user_view;
		$this->namespace = $namespace;
	}
	
	/**
	 * Shows the local public Tokenpass user page with
	 * the user information and token inventory
	 * @return void
	 */
	public function show() {
		$user_id = get_query_var( "{$this->namespace}_user_id" );
		if ( !$user_id ) {
			return false;
		}
		if ( $user_id == 'me' ) {
			$user = $this->current_user;
		} else {
			$user = $this->user_service->show( array(
				'id' => $user_id,
			) );
		}
		if ( !$user ) {
			return false;
		}
		$user->load( array( 'oauth_user' ) );
		if ( !isset( $user->oauth_user ) ) {
			return false;
		}
		$user->oauth_user->load( array( 'balance.token_meta' ) );
		$render = $this->user_view->render( array(
			'balance' => $user->oauth_user->balance,
			'user'     => $user,
		) );
		return $render;
	}
}
