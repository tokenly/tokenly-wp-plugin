<?php

namespace Tokenly\Wp\Interfaces\Controllers\Api\User\Token;

use Tokenly\Wp\Interfaces\Controllers\ControllerInterface;

use Tokenly\Wp\Interfaces\Models\UserInterface;

interface BalanceControllerInterface extends ControllerInterface {
	public function index( UserInterface $user, \WP_REST_Request $request );
}
