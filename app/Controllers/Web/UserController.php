<?php

namespace Tokenly\Wp\Controllers\Web;

use Tokenly\Wp\Interfaces\Repositories\BalanceRepositoryInterface;
use Tokenly\Wp\Views\UserView;
use Tokenly\Wp\Interfaces\Controllers\Web\UserControllerInterface;
use Tokenly\Wp\Interfaces\Repositories\UserRepositoryInterface;

/**
 * Serves the public user views
 */
class UserController implements UserControllerInterface {
	protected $balance_repository;
	protected $user_repository;
	protected $user_service;
	protected $user_view;

	public function __construct(
		BalanceRepositoryInterface $balance_repository,
		UserRepositoryInterface $user_repository,
		UserView $user_view
	) {
		$this->user_repository = $user_repository;
		$this->user_view = $user_view;
	}
	
	/**
	 * Shows the local public Tokenpass user page with
	 * the user information and token inventory
	 */
	public function show() {
		$user_id = get_query_var( 'tokenpass_user_id' );
		if ( !$user_id ) {
			return;
		}
		$user = $this->user_repository->show( array(
			'id' => $user_id,
		) );
		if ( !$user ) {
			return;
		}
		$balances = $user->get_balances( array(
			'with' => array( 'meta' ),
		) );
		$render = $this->user_view->render( array(
			'balances' => $balances,
		) );
		echo $render;
	}
}
