<?php

namespace Tokenly\Wp\Controllers\Web;

use Tokenly\Wp\Services\UserService;
use Tokenly\Wp\Views\UserView;

class UserController {
	public $user_service;

	public function __construct() {
		$this->user_service = new UserService();
	}
	
	public function show() {
		$balances = $this->user_service->get_inventory();
		$view = new UserView( array(
			'balances' => $balances,
		) );
		echo $view->render();
	}
}
