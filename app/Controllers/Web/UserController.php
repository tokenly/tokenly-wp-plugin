<?php

namespace Tokenly\Wp\Controllers\Web;

use Tokenly\Wp\Repositories\BalanceRepository;
use Tokenly\Wp\Services\UserService;
use Tokenly\Wp\Views\UserView;
use Tokenly\Wp\Controllers\Web\WebController;

/**
 * Serves the public user views
 */
class UserController extends WebController {
	public $balance_repository;
	public $user_service;
	public $user_view;

	public function __construct(
		BalanceRepository $balance_repository,
		UserService $user_service,
		UserView $user_view
	) {
		parent::__construct();
		$this->balance_repository = $balance_repository;
		$this->user_service = $user_service;
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
		$balances = $this->balance_repository->index( $user_id, true, true ) ?? array();
		$render = $this->user_view->render( array(
			'balances' => $balances,
		) );
		echo $render;
	}
}
