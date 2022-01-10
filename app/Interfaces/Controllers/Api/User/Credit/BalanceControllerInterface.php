<?php

namespace Tokenly\Wp\Interfaces\Controllers\Api\User\Credit;

use Tokenly\Wp\Interfaces\Controllers\ControllerInterface;

use Tokenly\Wp\Interfaces\Models\UserInterface;

interface BalanceControllerInterface extends ControllerInterface {
	public function index( UserInterface $users, \WP_REST_Request $request );
}
