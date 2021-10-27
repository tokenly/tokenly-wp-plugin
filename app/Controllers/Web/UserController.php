<?php

namespace Tokenly\Wp\Controllers\Web;

use Tokenly\Wp\Services\UserService;
use Tokenly\Wp\Views\UserView;
use Tokenly\Wp\Controllers\Web\WebController;

class UserController extends WebController {
	public $user_service;
	public $user_view;

	public function __construct(
		UserService $user_service,
		UserView $user_view
	) {
		parent::__construct();
		$this->user_service = $user_service;
		$this->user_view = $user_view;
	}
	
	public function show() {
		$id = get_query_var('tokenpass_user_id');
		$balances = $this->user_service->get_inventory( $id );
		$render = $this->user_view->render( array(
			'balances' => $balances,
		) );
		echo $render;
	}
}
