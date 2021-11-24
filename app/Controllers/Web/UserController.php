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

	public function __construct(
		UserServiceInterface $user_service,
		CurrentUserInterface $current_user,
		UserView $user_view
	) {
		$this->user_service = $user_service;
		$this->current_user = $current_user;
		$this->user_view = $user_view;
	}
	
	/**
	 * Shows the local public Tokenpass user page with
	 * the user information and token inventory
	 * @return void
	 */
	public function show() {
		$user_id = get_query_var( 'tokenpass_user_id' );
		if ( !$user_id ) {
			return;
		}
		if ( $user_id == 'me' ) {
			$user = $this->current_user;
		} else {
			$user = $this->user_service->show( array(
				'id' => $user_id,
			) );
		}
		if ( !$user ) {
			return;
		}
		$balances = $user->get_balances( array(
			'with' => array( 'meta' ),
		) );
		$render = $this->user_view->render( array(
			'balances' => $balances,
		) );
		return $render;
	}
}
